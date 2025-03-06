<div class="mmbr_pg_tbl">
    <div class="member_view_div">
      <div class="new">
      <div class="member_v_hdr">
      <div class="a">
      {{-- <h3><input type="checkbox" name="selectAll" id="selectAll" class="selectAll"></h3> --}}
      <h3>Logo</h3>
      <h3 class="nme">Name</h3>
      </div>
      <div class="b">
        <h3>Email</h3>
      <h3>Phone</h3>
      {{-- <h3>Mobile No.</h3> --}}
      </div>
      <div class="c">
      <h3></h3>
      <h3>Action</h3>
      <h3></h3>
      </div>
      </div>
      </div>
      <div class="member_view_b">
        @if($organizers->isNotEmpty())
          @foreach ($organizers as $organizer)
            <div class="member_row">
                  <div class="d">
                  <div class="mmbr_usr_ttl">
                    {{-- <input type="input" name="selected_members[]" value="{{ $organizer['_id'] }}" class="mmbr_usr_check" > --}}
                      <div class="mmbr_usrs">
                        <span><img id="" src="{{ $organizer['headerLogo'] ? asset($organizer['headerLogo']) : asset('images/noImage.jpg') }}" alt="Preview Img" /></span>
                      </div>
                  </div>
                  <h3 class="red">{!! $organizer['name'] !!}</h3>
                  </div>
                  <div class="e">
                    <h3>{{ $organizer['emailId'] }}</h3>
                    <h3>{{ $organizer['phoneNumber'] }}</h3>
                    {{-- <h3>{{ $organizer['Mobile'] }}</h3> --}}
                  </div>
          
                  <div class="f">
                    <div class="drv_tbl_icns dropdown">
                      <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-sort-up"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li>
                          <button class="dpdn_btn_icns pen">
                            <a href="{{ route('chiefadmin.editOrganizer', ['id' => $organizer['_id']]) }}">Edit</a>
                          </button>
                        </li>
                        <li>
                          <button class="dpdn_btn_icns trash">
                            <a href="javascript:void(0);"  onclick="confirmDelete('{{ $organizer['_id'] }}')">
                              Delete
                            </a>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
            </div>
            @endforeach
        @else
            <div class="member_row">
              No data available
            </div>
        @endif
      </div>
    </div>
</div>
<div class="page_pegination">
    {{ $organizers->links() }}
</div>