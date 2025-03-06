<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


@extends('layout.adminapp')

@section('content')
<div class="otr">
    <div class="container new">
        <div class="south_jst news_detailss">
            <div class="mul_form">
                <div class="multi_top_dir">Event Details</div>
                <div class="des_report">
                    <div class="rpot">
                        <div class="fst_tp_bx_lft">
                            <div class="fst_tp_bx">
                                <div class="fst_tp_bx_top">
                                    <label>{!! $event['title'] !!}</label>
                                    <div class="swiper mySwiper news_image_slider">
                                        <div class="swiper-wrapper">
                                            @php
                                                $bannerFilename = basename($event['bannerImage']);
                                            @endphp

                                            <div class="swiper-slide">
                                                <img src="{{ $event['bannerImage'] }}" alt="" class="news_dd_imgg nw_dtll">
                                            </div>

                                            @if (isset($event['eventImages']))
                                                @foreach ($event['eventImages'] as $item)
                                                    @php
                                                        $imageFilename = basename($item);
                                                    @endphp

                                                    @if ($imageFilename !== $bannerFilename) 
                                                        <div class="swiper-slide">
                                                            <img src="{{ $item }}" alt="" class="news_dd_imgg nw_dtll">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                      
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                    <div class="swiper-pagination2 new"></div>
                                </div>

                                <div class="frm_cnt">
                                    <div class="frm_row">
                                        <label>{!! $event['description'] !!} </label>
                                    </div>
                                    @php
                                        // Example date from the database
                                        $dateFromDb = $event['startDate']; // This should be an integer

                                        // Convert to string for easier manipulation
                                        $dateStr = (string) $dateFromDb;

                                        // Extract year, month, and day
                                        $year = substr($dateStr, 0, 4); // "2024"
                                        $month = substr($dateStr, 4, 2); // "10"
                                        $day = substr($dateStr, 6, 2); // "31"

                                        // Map numeric month to abbreviated month name
                                        $months = [
                                            '01' => 'Jan',
                                            '02' => 'Feb',
                                            '03' => 'Mar',
                                            '04' => 'Apr',
                                            '05' => 'May',
                                            '06' => 'Jun',
                                            '07' => 'Jul',
                                            '08' => 'Aug',
                                            '09' => 'Sep',
                                            '10' => 'Oct',
                                            '11' => 'Nov',
                                            '12' => 'Dec',
                                        ];

                                        // Format the date as desired
                                        $formattedDate = $day . '-' . $months[$month] . '-' . substr($year, 2);
                                    @endphp
                                    <label class="n_date">{{ $formattedDate }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
    <!-- Optional jQuery if using jQuery-based code -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var swiper = new Swiper(".news_image_slider", {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 20,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: true,
                },
                speed: 3000,
                pagination: {
                    el: ".swiper-pagination2",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });

            // Autoplay stop/start on hover
            $(".news_image_slider").mouseenter(function() {
                swiper.autoplay.stop();
            });
            $(".news_image_slider").mouseleave(function() {
                swiper.autoplay.start();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Find all oembed tags
            const oembeds = document.querySelectorAll('oembed');
            
            oembeds.forEach(function(oembed) {
                // Get the URL from the oembed tag
                const url = oembed.getAttribute('url');
                // Create the iframe element
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.width = '560';  // Set desired width
                iframe.height = '315'; // Set desired height
                iframe.frameBorder = '0';
                iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
                // Replace the oembed tag with the iframe
                oembed.parentNode.replaceChild(iframe, oembed);
            });
        });
    </script>
    
@endsection
