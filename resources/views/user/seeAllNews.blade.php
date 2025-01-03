@extends('layout.userapp')
@section('content')
<div class="otr mmbr_pg_ottr ">
    <div class="container new">
        <!-- <div class="mmbr_pg_innr">
            <div class="mmbr_pg_list">
                <div class="heading">
                    <h1>All News</h1>
                </div>
            </div>

        </div> -->
        <div class="see_nwss">
            <h1>All News</h1>
        </div>

        <!-- <div class="news_content">
            <div class="">
                <div class="mmbr_pg_tbl">
                    <div class="member_view_div sth_nws_admin">
                        <div class="new">
                            <div class="member_v_hdr">
                                <div class="a"><h3 class="nme">Logo</h3>
                                <h3>Title</h3></div>
                            </div>
                        </div>
                        @if (!empty($allNews) && $allNews->count() > 0)
                        @foreach ($allNews as $news)
                            <div class="member_view_b">
                                <div class="member_row">
                                    <div class="d">
                                        <div class="mmbr_usr_ttl">
                                            <div class="mmbr_usrs">
                                                <span>
                                                    <a href="{{ route('user.newsDetails', ['newsId' => $news['_id']]) }}">
                                                        <img src="{{ $news['image'] }}" alt="Preview Img">
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <h3 class="red">{{ $news['title'] }}</h3>
                                    </div>
                                    <div class="f">
                                        <div class="drv_tbl_icns dropdown">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="no-content">
                                <h6>sorry There is no content at this moment</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> -->
        <div class="all_n_ews">
            @if (!empty($allNews) && $allNews->count() > 0)
            @foreach ($allNews as $news)
            <div class="n_roww">
                <div class='nsw_img'>
                    <a href="{{ route('user.newsDetails', ['newsId' => $news['_id']]) }}">
                        <img src="{{ $news['image'] }}" alt="news-image"/>
                    </a>
                </div>
                <div class="n-cnttnt">
                <h3 class="red">{{ $news['title'] }}</h3>
                </div>
            </div>
            @endforeach
            @else
                <div class="no-content">
                    <h2>Sorry There is no content at this moment</h2>
                </div>
            @endif
        </div>
      
</div>
@endsection

@section('customJs')

@endsection