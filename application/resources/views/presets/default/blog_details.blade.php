@extends($activeTemplate . 'layouts.frontend')
@section('content')
    {{-- <section class="blog-details--section pt-200 pb-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details">
                        <div class="blog-item">
                            <div class="blog-item--thumb">
                                <img class="fit--img"
                                    src="{{ getImage(getFilePath('blog') . '/' . ($blog->data_values->blog_image ?? 'default.jpg')) }}"
                                    alt="@lang('blog-img')">
                            </div>
                            <div class="blog-item--content pt-3">
                                <ul class="text-list d-flex gap--16">
                                    <li class="text-list__item">
                                        <span class="text-list__item-icon d-flex align-items-center gap--8">
                                            <i class="fas fa-calendar-alt"></i>
                                            <p> {{ showDateTime($blog->created_at, 'd M Y') }}</p>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-details--content">
                            <h3 class="blog-details--title">{{ __($blog->data_values->title) }}</h3>

							 @php
                                $words = str_word_count($blog->data_values->description, 1);
                                $halfway = ceil(count($words) / 2);
                                $wordCount = 0;
                                $output = '';
                                $inserted = false;
                                foreach (explode(' ', $blog->data_values->description) as $word) {
                                    $output .= $word . ' ';
                                    $wordCount++;
                                    if ($wordCount == $halfway && !$inserted) {
                                        $output .=
                                            '<blockquote class="blog-details--quote2">' .
                                            __($blog->data_values->quote) .
                                            '</blockquote>';
                                        $inserted = true;
                                    }
                                }
                            @endphp
                            <div class="text--black7 wyg">
                                @php echo $output; @endphp
                            </div>

                            <div class="blog-details--share mt-4 d-flex align-items-center flex-wrap mb-5">
                                <h5 class="social-share--title mb-0 me-sm-3 me-1 d-inline-block">@lang('Share This'):</h5>
                                <ul class="social-list blog-details d-flex gap--12">
                                    <li class="social-list--item">
                                        <a href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug($blog->data_values->title) }}"
                                            class="social-list__link d-flex justify-content-center align-items-center"><i
                                                class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="social-list--item"><a
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug($blog->data_values->title) }}&source=behands"
                                            class="social-list__link d-flex justify-content-center align-items-center"><i
                                                class="fab fa-linkedin-in"></i></a></li>
                                    <li class="social-list--item"><a
                                            href="https://twitter.com/intent/tweet?status={{ slug($blog->data_values->title) }}+{{ Request::url() }}"
                                            class="social-list__link d-flex justify-content-center align-items-center"><i
                                                class="fab fa-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4">
                    <!--  Blog Details Sidebar Start  -->
                    <div class="blog-sidebar-wrapper">
                        <div class="row justify-content-end mb-4">
                            <div class="col-lg-12 col-md-12">
                                <form action="{{ route('blog') }}" method="GET">
                                    <div class="search--input  position-relative">
                                        <div class="input--group search--input d-flex flex-nowrap position-relative">
                                            <input type="text" class="form--control bg--white" id="searchValue"
                                                value="{{ request()->search }}" placeholder="@lang('Search by blog title')"
                                                name="search">
                                            <button class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="blog-sidebar base--card radius--12">
                            <h5 class="blog-sidebar--title fs--24 fw--600 d-inline-block position-relative">
                                @lang('Latests Topics')</h5>
                            @foreach ($latests as $item)
                                <div class="latest-blog d-flex flex-wrap">
                                    <div class="latest-blog--thumb">
                                        <a
                                            href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                            <img src="{{ getImage(getFilePath('blog') . '/blog' . '/' . 'thumb_' . ($item->data_values->blog_image ?? 'default.jpg')) }}"
                                                alt="@lang('blog-image')"></a>
                                    </div>
                                    <div class="latest-blog--content">
                                        <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}"
                                            class="latest-blog--title fs--16 fw--600 w-100">
                                            @if (strlen(__($item->data_values->title)) > 30)
                                                {{ substr(__($item->data_values->title), 0, 30) . '...' }}
                                            @else
                                                {{ __($item->data_values->title) }}
                                            @endif
                                        </a>

                                        <span class="latest-blog--date fs--14">{{ showDateTime($item->created_at) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Blog Details Sidebar End-->
                </div>
            </div>
        </div>
    </section> --}}


    <!--==========================  Blog Details Section Start  ==========================-->
    <div class="blog__details pt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <img src="{{ getImage(getFilePath('blog') . '/' . $blog->data_values->blog_image) }}"
                            alt="@lang('image')">
                        <div class="blog__date">
                            <span>{{ showDateTime($blog->created_at, 'd M Y') }}</span>
                        </div>
                        <h1>{{ __($blog->data_values->title) }}</h1>
                        @php
                            $words = str_word_count($blog->data_values->description, 1);
                            $halfway = ceil(count($words) / 2);
                            $wordCount = 0;
                            $output = '';
                            $inserted = false;
                            foreach (explode(' ', $blog->data_values->description) as $word) {
                                $output .= $word . ' ';
                                $wordCount++;
                                if ($wordCount == $halfway && !$inserted) {
                                    $output .=
                                        '<div class="blog__quote"><p>' .
                                        __($blog->data_values->quote) .
                                        '</p>
										<span><i class="fa-solid fa-quote-right"></i></span>
										</div>';
                                    $inserted = true;
                                }
                            }
                        @endphp
                        <div class="text--black7 wyg">
                            @php echo $output; @endphp
                        </div>
                    </div>
                    <div class="blog__share d-flex justify-content-between flex-wrap">
                        <h6><i class="fa-solid fa-share-nodes"></i> @lang('Share This post')</h6>
                        <ul class="social__icon dark__social">
                            <li>
                                <a href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug($blog->data_values->title) }}"
                                    target="_blank">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug($blog->data_values->title) }}&source=behands"
                                    target="_blank">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?status={{ slug($blog->data_values->title) }}+{{ Request::url() }}"
                                    target="_blank">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{ slug($blog->data_values->title) }}"
                                    target="_blank">
                                    <i class="fa-brands fa-pinterest-p"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog__sidebar">
                        <form action="{{ route('blog') }}" method="GET">
                            <div class="search__box">
                                <input type="text" class="form-control" id="searchValue" value="{{ request()->search }}"
                                    placeholder="@lang('Search by blog title')" name="search">
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <div class=" mt-4">
                            <div class="recent__blog">
                                <div class="recent__blog__title">
                                    <h4>@lang('Latests Posts')</h4>
                                </div>
                                <div class="recent__blog__wrap">
                                    @foreach ($latests as $item)
                                        <div class="recent__blog__single">
                                            <a
                                                href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                                <img
                                                    src="{{ getImage(getFilePath('blog') . 'thumb_' . ($item->data_values->blog_image ?? 'default.jpg')) }}">
                                                <img src="{{ getImage(getFilePath('blog') .'thumb_' . $item->data_values->blog_image) }}"
                                                    alt="@lang('image')"></a>
                                            <div>
                                                <h6>
                                                    <a class="fs-16 fw--500"
                                                        href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                                        @if (strlen(__($item->data_values->title)) > 30)
                                                            {{ substr(__($item->data_values->title), 0, 30) . '...' }}
                                                        @else
                                                            {{ __($item->data_values->title) }}
                                                        @endif
                                                    </a>
                                                </h6>
                                                <p>
                                                    <i class="fa-regular fa-calendar"></i>
													{{ showDateTime($item->created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==========================  Blog Details Section End  ==========================-->
@endsection
