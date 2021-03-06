<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'task';
    protected $hidden = ['creator', 'created_at', 'updated_at', 'updater'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $touches = ['matter'];
    protected $dates = [
        'due_date',
        'done_date'
    ];


    public function setDueDateAttribute($value)
    {
        $locale = Carbon::getLocale();
        $this->attributes['due_date'] = Carbon::createFromLocaleIsoFormat('L', $locale, $value);
    }

    public function setDoneDateAttribute($value)
    {
        $locale = Carbon::getLocale();
        $this->attributes['done_date'] = Carbon::createFromLocaleIsoFormat('L', $locale, $value);
    }

    public function info()
    {
        return $this->belongsTo('App\EventName', 'code');
    }

    public function trigger()
    {
        return $this->belongsTo('App\Event', 'trigger_id');
    }

    public function matter() {
        return $this->hasOneThrough('App\Matter', 'App\Event', 'id', 'id', 'trigger_id', 'matter_id');
    }

    public static function getUsersOpenTaskCount()
    {
        $userid = Auth::user()->id;
        $role = Auth::user()->default_role;
        $selectQuery = Task::join('event as e', 'task.trigger_id', 'e.id')
            ->join('matter as m', 'e.matter_id', 'm.id')
            ->select(
                DB::raw('count(*) as no_of_tasks'),
                DB::raw('MIN(task.due_date) as urgent_date'),
                DB::raw('ifnull(task.assigned_to, m.responsible) as login')
            )
            ->where([
              ['m.dead', 0],
              ['task.done', 0]
            ])
            ->groupby('login');

        if ($role == 'CLI') {
            $selectQuery->join('matter_actor_lnk as cli', 'cli.matter_id', DB::raw('ifnull(m.container_id, m.id)'))
            ->where([
              ['cli.role', 'CLI'],
              ['cli.actor_id', $userid]
            ]);
        }
        return $selectQuery->get();
    }

    public function openTasks($renewals, $what_tasks, $user_dasboard)
    {
        $tasks = $this->select('task.id', 'en.name', 'task.detail', 'task.due_date', 'event.matter_id', 'matter.uid', 'tit.value as title', 'tm.value as trademark')
        ->join('event_name as en', 'task.code', 'en.code')
        ->join('event', 'task.trigger_id', 'event.id')
        ->join('matter', 'event.matter_id', 'matter.id')
        ->leftJoin('classifier as tit', function ($j) {
          $j->on('tit.matter_id', DB::raw('ifnull(matter.container_id, matter.id)'))
            ->where([
              ['tit.type_code', 'TIT'],
              ['tit.display_order', 1]
            ]);
        })
        ->leftJoin('classifier as tm', function ($j) {
          $j->on('tm.matter_id', DB::raw('ifnull(matter.container_id, matter.id)'))
            ->where('tm.type_code', 'TM');
        })
        ->where([
          ['task.done', 0],
          ['matter.dead', 0]
        ]);

        if($what_tasks == 1) {
            $tasks->where('assigned_to', Auth::user()->login);
        }

        // A client is defined for querying the tasks
        if($what_tasks > 1) {
            $tasks->join('matter_actor_lnk as cli', 'cli.matter_id', DB::raw('ifnull(matter.container_id, matter.id)'))
            ->where([
              ['cli.role', 'CLI'],
              ['cli.actor_id', $what_tasks]
            ]);
        }

        if ($renewals) {
            $tasks->where('task.code', 'REN');
        } else {
            $tasks->where('task.code', '!=', 'REN');
        }

        if (Auth::user()->default_role == 'CLI') {
            $tasks->join('matter_actor_lnk as cli', 'cli.matter_id', DB::raw('ifnull(matter.container_id, matter.id)'))
            ->where([
              ['cli.role', 'CLI'],
              ['cli.actor_id', Auth::user()->id]
            ]);
        }

        if ($user_dasboard) {
            $tasks->where (function ($q) use ($user_dasboard){
              $q->where('matter.responsible', $user_dasboard)
              ->orWhere('task.assigned_to', $user_dasboard);
            });
        }

        return $tasks->orderby('due_date');
    }
}
