<div class="card overflow-auto" style="height: 480px;">
  <div class="nav nav-pills" role="tablist">
    <a class="nav-item nav-link active" data-toggle="tab" href="#actorMain" role="tab">Main</a>
    <a class="nav-item nav-link" data-toggle="tab" href="#actorContact" role="tab">Contact</a>
    <a class="nav-item nav-link" data-toggle="tab" href="#actorOther" role="tab">Other</a>
    <a class="nav-item nav-link" data-toggle="tab" id="actorUsedInToggle" href="/actor/{{ $actorInfo->id }}/usedin" data-target="#actorUsedIn" role="tab">Used in</a>
    @canany(['admin', 'readwrite'])
    <button id="deleteActor" title="Delete actor" class="nav-item nav-link btn btn-outline-danger"  data-url='/actor/{{ $actorInfo->id }}' data-message="the actor {{ $actorInfo->name }}">
      Delete
    </button>
    @endcanany
  </div>
  <div class="tab-content p-1" data-resource="/actor/{{ $actorInfo->id }}">
    <fieldset class="tab-pane fade show active" id="actorMain">
      <table class="table table-striped table-sm">
        <tr>
          <th><label title="{{ $actorComments['name'] }}">Name</label> </th>
          <td><input class="noformat form-control" name="name" value="{{ $actorInfo->name }}"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['first_name'] }}">First name</label></th>
          <td><input class="noformat form-control" name="first_name" value="{{ $actorInfo->first_name }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['display_name'] }}">Display name</label></th>
          <td><input type="text" class="noformat form-control" name="display_name" value="{{ $actorInfo->display_name }}" placeholder="-"></td>
        </tr>
        <tr>
          <th>Address</th>
          <td><textarea class="noformat form-control" name="address">{{ $actorInfo->address }}</textarea></td>
        </tr>
        <tr>
          <th>Country</th>
          <td><input type='text' class="noformat form-control" name="country" data-ac="/country/autocomplete" value="{{ empty($actorInfo->countryInfo) ? '' : $actorInfo->countryInfo->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th>Nationality</th>
          <td><input type="text" class="noformat form-control" name="nationality" data-ac="/country/autocomplete" value="{{ empty($actorInfo->nationalityInfo) ? '' : $actorInfo->nationalityInfo->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['function'] }}">Function</label></th>
          <td><input type="text" class="noformat form-control" name="function" value="{{ $actorInfo->function }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['company_id'] }}">Employer</label></th>
          <td><input type="text" class="noformat form-control" name="company_id" data-ac="/actor/autocomplete" value="{{ empty($actorInfo->company) ? '' : $actorInfo->company->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['phy_person'] }}">Physical Person</label></td>
          <td><input type="checkbox" class="noformat" name="phy_person" {{ $actorInfo->phy_person ? 'checked' : '' }}></th>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['small_entity'] }}">Small Entity</label></th>
          <td><input type="checkbox" class="noformat" name="small_entity" {{ $actorInfo->small_entity ? 'checked' : '' }}></td>
        </tr>
        <tr>
          <td colspan="2">
            <label class="font-weight-bolder" title="{{ $actorComments['notes'] }}">Notes</label>
            <textarea class="noformat form-control" name="notes">{{ $actorInfo->notes }}</textarea>
          </td>
        </tr>
      </table>
    </fieldset>
    <fieldset class="tab-pane fade" id="actorContact">
      <table class="table table-striped">
        <tr>
          <th>Address mailing</th>
          <td><textarea class="noformat form-control" name="address_mailing">{{ $actorInfo->address_mailing }}</textarea></td>
        </tr>
        <tr>
          <th>Country mailing</th>
          <td><input type='text' class="noformat form-control" name="country_mailing" data-ac="/country/autocomplete" value="{{ empty($actorInfo->country_mailingInfo ) ? '' : $actorInfo->country_mailingInfo->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th>Address billing</th>
          <td><textarea class="noformat form-control" name="address_billing">{{ $actorInfo->address_billing }}</textarea></td>
        </tr>
        <tr>
          <th>Country billing</th>
          <td><input class="noformat form-control" name="country_billing" data-ac="/country/autocomplete" value="{{ empty($actorInfo->country_billingInfo ) ? '' : $actorInfo->country_billingInfo->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th>Email</th>
          <td><input type='email' class="noformat form-control" name="email" value="{{ $actorInfo->email }}" placeholder="-"></td>
        </tr>
        <tr>
          <th>Phone</th>
          <td><input type='text' class="noformat form-control" name="phone" value="{{ $actorInfo->phone }}" placeholder="-"></td>
        </tr>
      </table>
    </fieldset>
    <fieldset class="tab-pane fade" id="actorOther">
      <table class="table table-striped">
        <tr>
          <th><label title="{{ $actorComments['login'] }}">Login</label></th>
          <td><input type="text" class="noformat form-control" name="login" value="{{ $actorInfo->login }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['default_role'] }}" title="Login needs to be null for changing the role">Default role</label></th>
          <td><input type="text" class="noformat form-control" name="default_role" data-ac="/role/autocomplete" value="{{ empty($actorInfo->droleInfo) ? '' : $actorInfo->droleInfo->name }}" {{ $actorInfo->login ? 'disabled' : 'autocomplete=off' }} placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['warn'] }}">Warn</label></th>
          <td><input type="checkbox" class="noformat" name="warn" {{ $actorInfo->warn ? 'checked' : '' }}></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['legal_form'] }}">Legal form</label></th>
          <td><input type='text' class="noformat form-control" name="legal_form" value="{{ $actorInfo->legal_form }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['registration_no'] }}">Registration no.</label></th>
          <td><input type='text' class="noformat form-control" name="registration_no" value="{{ $actorInfo->registration_no }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['VAT_number'] }}">VAT no.</label></th>
          <td><input type='text' class="noformat form-control" name="VAT_number" value="{{ $actorInfo->VAT_number }}" placeholder="-"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['parent_id'] }}">Parent company</label></th>
          <td><input type="text" class="noformat form-control" name="parent_id" data-ac="/actor/autocomplete" value="{{ empty($actorInfo->parent) ? '' : $actorInfo->parent->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
        <tr>
          <th><label title="{{ $actorComments['site_id'] }}">Work site</label></th>
          <td><input type="text" class="noformat form-control" name="site_id" data-ac="/actor/autocomplete" value="{{ empty($actorInfo->site) ? '' : $actorInfo->site->name }}" placeholder="-" autocomplete="off"></td>
        </tr>
      </table>
    </fieldset>
    <div class="tab-pane fade" id="actorUsedIn">
      <div class="spinner-border" role="status"></div>
    </div>
  </div>
</div>
