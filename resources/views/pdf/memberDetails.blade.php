<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details</title>
    <style>
        body {
        background-color: #fdf1fb;
        margin: 0;
        padding: 20px;
        /* height: 100%;
        width: 100%; */
        }
        html {
            height: 100%;
            width: 100%;
        }

        .container {
            display: flex;
            justify-content: space-between;
        }
        .content {
            flex: 3;
        }
        .image {
            flex: 1;
            text-align: center;
        }
        img {
            max-width: 100%;
            height: 250px;
        }
        .details p {
            margin: 12px 0;
        }
    </style>
</head>
<body>
    <h1>Member Details</h1>
    <div class="container">
        <!-- Text Content -->
        <div class="content details">
            @if (!empty($Members_Type))
                <p><strong>Membership Type:</strong> {{ $Members_Type }}</p>
            @endif

            @if (!empty($Membership_No))
                <p><strong>Membership No:</strong> {{ $Membership_No }}</p>
            @endif

            @if (!empty($Name) || !empty($Middle_Name) || !empty($Surname))
                <p><strong>Full Name:</strong> 
                    {{ trim(($Name ?? '') . ' ' . ($Middle_Name ?? '') . ' ' . ($Surname ?? '')) }}
                </p>
            @endif

            @if (!empty($Son_Daughter_of))
                <p><strong>Son/Daughter of:</strong> {{ $Son_Daughter_of }}</p>
            @endif

            @if (!empty($Residence1) || !empty($Residence2) || !empty($Residence3) || !empty($Residence4) || !empty($Res_PINCODE))
                <p><strong>Residence Address:</strong>
                    {{ $Residence1 }} {{ $Residence2 }} {{ $Residence3 }} {{ $Residence4 }} {{ $Res_PINCODE }}
                </p>
            @endif

            @if (!empty($Phone))
                <p><strong>Residence Phone:</strong> {{ $Phone }}</p>
            @endif

            @if (!empty($Mobile))
                <p><strong>Mobile:</strong> {{ $Mobile }}</p>
            @endif

            @if (!empty($Email_ID))
                <p><strong>Email ID:</strong> {{ $Email_ID }}</p>
            @endif

            @if (!empty($Office_1) || !empty($Office_2) || !empty($Office_3) || !empty($Office_4) || !empty($PINCODE))
                <p><strong>Office Address:</strong>
                    {{ $Office_1 }} {{ $Office_2 }} {{ $Office_3 }} {{ $Office_4 }} {{ $PINCODE }}
                </p>
            @endif

            @if (!empty($Phone_O))
                <p><strong>Office Phone:</strong> {{ $Phone_O }}</p>
            @endif

            @if (!empty($Mobile_O))
                <p><strong>Office Mobile:</strong> {{ $Mobile_O }}</p>
            @endif

            @if (!empty($Qualification))
                <p><strong>Qualification:</strong> {{ $Qualification }}</p>
            @endif

            @if (!empty($Occupation))
                <p><strong>Occupation:</strong> {{ $Occupation }}</p>
            @endif

            @if (!empty($Deals_In))
                <p><strong>Deals In:</strong> {{ $Deals_In }}</p>
            @endif

            @if (!empty($DOB))
                <p><strong>Date of Birth (DOB):</strong> {{ $DOB }}</p>
            @endif

            @if (!empty($DOM))
                <p><strong>Date of Marriage (DOM):</strong> {{ $DOM }}</p>
            @endif

            @if (!empty($Spouse))
                <p><strong>Spouse:</strong> {{ $Spouse }}</p>
            @endif

            @if (!empty($Native_Place))
                <p><strong>Native Place:</strong> {{ $Native_Place }}</p>
            @endif

            @if (!empty($age))
                <p><strong>Age:</strong> {{ $age }}</p>
            @endif

            @if (!empty($businessName))
                <p><strong>Business Name:</strong> {{ $businessName }}</p>
            @endif

            @foreach (range(1, 6) as $i)
                @if (!empty(${"familyMember{$i}Name"}) || !empty(${"familyMember{$i}Phone"}) || !empty(${"familyMember{$i}Relation"}))
                    <p><strong>Family Member {{ $i }}:</strong></p>
                    <p>
                        @if (!empty(${"familyMember{$i}Name"}))
                            &nbsp;&nbsp;Name: {{ ${"familyMember{$i}Name"} }},
                        @endif
                        @if (!empty(${"familyMember{$i}Phone"}))
                            &nbsp;&nbsp;Phone: {{ ${"familyMember{$i}Phone"} }},
                        @endif
                        @if (!empty(${"familyMember{$i}Relation"}))
                            &nbsp;&nbsp;Relation: {{ ${"familyMember{$i}Relation"} }}
                        @endif
                    </p>
                @endif
            @endforeach
        </div>
        @if (!empty($image))
            <div class="image">
                    <img src="{{ $image }}" alt="Member Image">
                </div>
            </div>
        @endif
</body>
</html>
