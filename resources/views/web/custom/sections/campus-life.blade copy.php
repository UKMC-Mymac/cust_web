<section id="campus_life" class="campus overflow-hidden space">
    <div class="campus-shape jump shape-mockup  d-none d-xxl-block" data-bottom="22%" data-right="5%">
        <img src="{{ asset('dist/img/shape/campus-1-1.png') }}" alt="shape">
    </div>
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
            @isset($contentSections['campus_life'])
                @php
                    $section = $contentSections['campus_life'];
                @endphp
            <div class="col-lg-8 col-12">
                <div class="title-area text-center text-lg-start">
                    <span class="sub-title text-anim">{{ $section->subtitle }}</span>
                    <h2 class="sec-title text-anim2">{{ $section->title}}</h2>
                </div>
            </div>
            @endisset
            <div class="col-auto align-self-end">
                <div class="sec-btn">
                    <a href="{{route('campus-life')}}" class="th-btn style-border1 th-icon wow fadeInUp" data-wow-delay=".2s">Explore All</a>
                </div>
            </div>
        </div>
        <div class="row gy-5 justify-content-center">
            @foreach ( $campus_lifes as $campusLife )

                <div class="col-xl-4 col-lg-6">
                <div class="campus-card wow fadeInLeft" data-wow-delay=".2s">
                    <div class="campus-img global-img">
                        <img src="{{ asset('uploads/campus-life/' . $campusLife->attach) }}" alt="{{ $campusLife->title }}" class="img-1">
                    </div>
                    <div class="campus-content">
                        <h3 class="box-title"><a href="{{ route('campus-life.single', ['slug' => $campusLife->slug]) }}">{{ $campusLife->title }}</a></h3>
                        <p class="box-text">
                            {{ $campusLife->feature_text }}
                        </p>
                    </div>
                    <a href="{{ route('campus-life.single', ['slug' => $campusLife->slug]) }}" class="th-btn style-border1 th-icon">{{$campusLife->button_text}}</a>
                </div>
            </div> 
            @endforeach
           
        </div>
    </div>
</section>
