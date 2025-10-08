 @forelse ($blogs ?? [] as $item)
     <div class="col-xl-4 col-lg-4 col-md-6">
         <div class="news-card">
             <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}"
                 class="news-thumb">
                 <img class="news-image"
                     src="{{ getImage(getFilePath('blog') . 'thumb_' . $item->data_values->blog_image) }}"
                     alt="@lang('news-card')">
             </a>
             <div class="news-content">
                 <p class="news-date">{{ showDateTime($item->created_at, 'd M,Y') }}</p>
                 <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                     <h3 class="news-title">
                         @if (strlen(__($item->data_values->title)) > 55)
                             {{ strLimit(__($item->data_values->title), 55) }}
                         @else
                             {{ __($item->data_values->title) }}
                         @endif
                     </h3>
                 </a>
                 <p class="news-desc">8
                     @if (strlen(__(strip_tags($item->data_values->description))) > 80)
                         {{ strLimit(__(strip_tags($item->data_values->description)), 80) }}
                     @else
                         {{ __(strip_tags($item->data_values->description)) }}
                     @endif
                 </p>
                 <div class="news-button d-flex align-items-center gap--12">
                     <span class="news-shape"></span>
                     <a class="news-read-more"
                         href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                         @lang('Read More')
                     </a>
                 </div>
             </div>
         </div>
     </div>
 @empty
     <div class="col-12 text-center">
         <h6>@lang('No Data Found')</h6>
     </div>
 @endforelse
