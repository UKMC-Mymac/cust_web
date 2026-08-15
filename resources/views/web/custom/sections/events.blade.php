<style>
    #event-sec .bangla-text {
        font-family: "Noto Sans Bengali", var(--body-font), sans-serif;
    }
    
    /* Events Section Responsive Optimization */
    @media (max-width: 767px) {
        #event-sec .event-card .box-title {
            font-size: 20px !important;
            line-height: 28px !important;
            margin-bottom: 10px !important;
        }
        #event-sec .event-card .box-text {
            font-size: 14px !important;
            line-height: 1.6 !important;
            margin-bottom: 15px !important;
        }
    }
    
    @media (max-width: 575px) {
        #event-sec .event-card .box-title {
            font-size: 18px !important;
            line-height: 26px !important;
        }
        #event-sec .event-card .box-text {
            font-size: 13px !important;
            line-height: 1.5 !important;
        }
    }
</style>
<section class="event-area-1 position-relative overflow-hidden space" id="event-sec">
    <div class="event-shape shape-mockup d-none d-xxl-block" data-top="0%" data-left="0%">
        <img src="{{ asset('dist/img/shape/shape-2.png') }}" alt="">
    </div>
    <div class="event-shape jump shape-mockup  d-none d-xxl-block" data-bottom="0%" data-left="3%">
        <img src="{{ asset('dist/img/shape/event-1-1.png') }}" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            <div class="col-lg-8 col-12">
                @isset($contentSections['news-event'])
                  <div class="title-area text-center text-lg-start">
                    <span class="sub-title text-anim">{{ $contentSections['news-event']->subtitle }}</span>
                    <h2 class="sec-title text-anim2">{{ $contentSections['news-event']->title }}</h2>
                </div>   
                @endisset
               
            </div>
            <div class="col-auto align-self-end">
                <div class="sec-btn wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ route('event') }}" class="th-btn style-border1 th-icon">Explore All</a>
                </div>
            </div>
        </div>
        <div class="event-card-wrap">
            @if(isset($events) && $events->count())
                @foreach($events as $event)
                <div class="event-card wow fadeInUp" data-wow-delay="{{ sprintf('%.1fs', 0.2 * ($loop->index + 1)) }}">
                    <div class="event-card-img global-img position-relative">
                        <img src="{{ $event->attach ? asset('uploads/web-event/'.$event->attach) : asset('dist/images/homepage/news-1.jpg') }}" alt="event">
                        <p class="event-card-tag"><span class="tag-number">{{ date('d', strtotime($event->date)) }}</span>{{ date('M', strtotime($event->date)) }}</p>
                        @if(!empty($event->pinned))
                            <span class="position-absolute top-0 start-0 m-3 p-2 rounded bg-warning text-dark text-center shadow-sm" style="z-index: 10; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;" title="{{ __('field_pinned') }}: {{ $event->pinned }}">
                                <i class="fa-solid fa-thumbtack"></i>
                            </span>
                        @endif
                    </div>
                    <div class="event-content">
                        <div class="event-wrapp">
                            <h4 class="h4 box-title bangla-text">
                                <a href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}">{{ $event->title }}</a>
                            </h4>
                            <p class="box-text bangla-text">
                                {{ \Illuminate\Support\Str::limit($event->feature_text ?? '', 160) }}
                            </p>
                            <div class="blog-meta">
                                <a class="location" href="#"><i class="fa-solid fa-location-dot"></i> {{ $event->address }}</a>
                                <a class="date" href="#"><i class="fa-regular fa-calendar-days"></i> {{ date('d.m.Y', strtotime($event->date)) }}</a>
                                @if($event->time)
                                <a class="time" href="#"><i class="fa-solid fa-clock"></i> {{ $event->time }}</a>
                                @endif
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a class="th-btn style-border1 th-icon" href="{{ route('event.single', ['id' => $event->id, 'slug' => $event->slug]) }}">Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
