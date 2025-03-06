<div class="mmbr_pg_tbl">
  <div class="member_view_div">
    <div class="new">
    <div class="member_v_hdr">
    <div class="a">
    <h3><input type="checkbox" name="selectAll" id="selectAll" class="selectAll"></h3>
    <h3></h3>
    <h3 class="nme">Name</h3>
    </div>
    <div class="b">
    <h3>Membership No.</h3>
    <h3>Membership Type</h3>
    <h3>Mobile No.</h3>
    </div>
    <div class="c">
    <h3>Status</h3>
    <h3>Action</h3>
    <h3>Connect</h3>
    </div>
    </div>
    </div>
    <div class="member_view_b">
      @if($members->isNotEmpty())
        @foreach ($members as $member)
          <div class="member_row">
                <div class="d">
                
                <div class="mmbr_usr_ttl">
                  <input type="checkbox" name="selected_members[]" value="{{ $member['_id'] }}" class="mmbr_usr_check" data-mobile="{{ $member['Mobile'] }}">
                    <div class="mmbr_usrs">
                      <span><img id="" src="{{ $member['image'] ? asset($member['image']) : asset('images/noImage.jpg') }}" alt="Preview Img" /></span>
                    </div>
                </div>
                <h3 class="red">{{ $member['Name'] }} {{ $member['Middle_Name'] }} {{ $member['Surname'] }}</h3>
                </div>
                <div class="e">
                <h3>{{ $member['Membership_No'] }}</h3>
                <h3>{{ $member['Members_Type'] }}</h3>
                <h3>{{ $member['Mobile'] }}</h3>
                </div>
        
                <div class="f">
                <h3>@if($member['isVerified'] === 'Yes')
                        <button class="mmbr_stt tick"><i class="fas fa-check"></i></button>
                    @elseif($member['isVerified'] === 'reverified')
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 12L9 17L20 6" stroke="red" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    @else
                        <button class="mmbr_stt cross"><i class="fas fa-times"></i></button>
                    @endif</h3>
                <div class="drv_tbl_icns dropdown">
                          <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-sort-up"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <button class="dpdn_btn_icns pen">
                                <a href="{{route('admin.editMember', ['id' => $member['_id']])}}">Edit</a>
                              </button>
                            </li>
                            <li>
                              <button class="dpdn_btn_icns trash">
                                <a href="javascript:void(0);"  onclick="confirmDelete('{{ $member['_id'] }}')">
                                  Delete
                                </a>
                              </button>
                            </li>
                            @if($member['isVerified']== "Yes")
                            <li>
                                <form action="{{ route('admin.reverifyMember', ['id' => $member['_id']]) }}" method="GET">
                                    <button type="submit" class="dpdn_btn_icns reverify">
                                        Reverify
                                    </button>
                                </form>
                            </li>
                            @endif
                          </ul>
                        </div>
                        <div class="cnct_icns new">
                          <button class="cnct_icns_btn sms" data-mobile="{{ $member['Mobile'] }}" data-id="{{ $member['_id'] }}"><i class="fas fa-sms"></i></button>
                          <button class="cnct_icns_btn whts" data-mobile="{{ $member['Mobile'] }}" data-id="{{ $member['_id'] }}" data-name="{{ $member['Name']}}" data-midname="{{ $member['Middle_Name']}}" data-surname="{{ $member['Surname'] }}"><i class="fab fa-whatsapp"></i></button>
                          @if ($member['isVerified'] === 'Yes')
                            <div class="tooltip-container" data-tooltip="Download PDF">
                              <button class="cnct_icns_btn pdf" data-id="{{ $member['_id'] }}" data-name="{{ $member['Name']}}" data-midname="{{ $member['Middle_Name']}}" data-surname="{{ $member['Surname'] }}"><i class="fa-solid fa-download" style="color: red"></i></button>
                            </div>
                          @else
                            {{-- <button class="cnct_icns_btn" data-id="{{ $member['_id'] }}"  style="color: white">B</button> --}}
                            &nbsp;
                          @endif
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
    {{ $members->links() }}
</div>
<script>
  $(document).ready(function() {
      // SMS button click event
      // $(".cnct_icns_btn.sms").click(function() {
      //     // Get mobile number and member ID
      //     const mobileNumber = $(this).data("mobile");
      //     const memberId = $(this).data("id");

          // Set the values in the modal
      //     $("#mobileNumberInput").val(mobileNumber);
      //     $("#memberIdInput").val(memberId);

      //     // Show the modal
      //     $("#smsModal").modal("show");
      // });

      // // Form submission for sending SMS
      // $("#smsForm").submit(function(e) {
      //     e.preventDefault();

      //     const message = $("#message").val();
      //     const mobileNumber = $("#mobileNumberInput").val();

          // $.ajax({
          // url: "/admin/send-sms",
          // method: "POST",
          // data: {
          //     mobile_number: mobileNumber,
          //     memberId: memberId,
          //     _token: "{{ csrf_token() }}" // Laravel CSRF token
          // },
          // success: function(response) {
          //     if (response.success) {
          //         console.log("Message sent: " + response.success);
          //     alert("SMS sent successfully!");
          //     $("#smsModal").modal("hide");
          //     window.location.reload();
          //     } else {
          //     alert("Failed to send SMS.");
          //     }
          // },
          // error: function(error) {
          //     console.error("Error:", error);
          // }
          // });
      // });

      // //wp button click event
      // $(".cnct_icns_btn.whts").click(function() {
      //     const mobileNumber = $(this).data("mobile");
      //     const wpMemberId = $(this).data("id");
          
      //     // Set values in the modal
      //     $("#whatsappNumber").val(mobileNumber);
      //     $("#wpMemberIdInput").val(wpMemberId);
      //     $("#whatsappMessage").val();

      //     // Show the modal
      //     $("#whatsappModal").modal("show");
      // });

      // // Form submission for sending wp
      // $("#whatsappForm").submit(function(e) {
      //     e.preventDefault();

      //     const mobileNumber = $("#whatsappNumber").val();
      //     const message = $("#whatsappMessage").val();

      //     // Construct WhatsApp deep link
      //     const whatsappUrl = `https://wa.me/${mobileNumber}?text=${encodeURIComponent(message)}`;

      //     // Open WhatsApp in a new tab
      //     window.open(whatsappUrl, "_blank");

      //     // Close the modal after opening WhatsApp
      //     $("#whatsappModal").modal("hide");
      //     window.location.reload();
      // });

      // wp button click event
      $(".cnct_icns_btn.whts").click(function(e) {
          e.preventDefault();

          const mobileNumber = $(this).data("mobile");
          const wpid = $(this).data("id");
          const wpname = $(this).data("name");
          const wpmidname = $(this).data("midname");
          const wpsurname = $(this).data("surname");

          const fullName = `${wpname} ${wpmidname} ${wpsurname}`;
          const message = `${fullName},\n\nKindly update your membership data & family details in the below link:\n\ntinyurl.com/southsaba\n\nSouth Sabha`;
          // Construct WhatsApp deep link
          const whatsappUrl = `https://wa.me/${mobileNumber}?text=${encodeURIComponent(message)}`;

          window.open(whatsappUrl, "_blank");

          // Close the modal after opening WhatsApp
          // $("#whatsappModal").modal("hide");
          // window.location.reload();
      });

      $('#selectAll').click(function() {
          $('.mmbr_usr_check').prop('checked', this.checked);
      });

      // On SMS button click, send SMS to selected members
      $('#sendSMSBtn').click(function() {
          var selectedMembers = [];
          
          // Get the selected member IDs and their mobile numbers
          $('.mmbr_usr_check:checked').each(function() {
              var memberId = $(this).val();
              var mobile = $(this).data('mobile');
              selectedMembers.push({ memberId: memberId, mobile: mobile });
          });
          console.log(selectedMembers);

          if (selectedMembers.length > 0) {
              // Send the selected members' data to the backend
              // $.ajax({
              //     url: '/admin/sendAll-sms', // Backend route to send SMS
              //     method: 'POST',
              //     data: {
              //         _token: '{{ csrf_token() }}', // CSRF token for security
              //         selected_members: selectedMembers,
              //         // message: "SOUTH_CALCUTTA_SHRI_JAIN"
              //     },
              //     success: function(response) {
              //         console.log('hi');
              //         alert('SMS sent successfully to selected members!');
              //     },
              //     error: function(xhr, status, error) {
              //         alert('Failed to send SMS. Please try again.');
              //     }
              // });
          } else {
              alert('Please select at least one member.');
          }
      });
  });

</script>
