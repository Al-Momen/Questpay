@php
  $content = getContent('custom_banktransfer.content', true);
@endphp

<div class="row">
    <div class="col-lg-12">
        @php echo $content->data_values->textarea ?? ''; @endphp
    </div>
</div>
