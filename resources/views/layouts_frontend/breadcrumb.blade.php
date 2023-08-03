<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url('/'); ?>">Home</a></li>
    @foreach ($breadcrumb as $key => $value)
      @if ($key < count($breadcrumb) - 1)
        <li class="breadcrumb-item"><a href="{{ $value['link'] }}">{{ $value['name'] }}</a></li>
      @else
        <li class="breadcrumb-item active" aria-current="page">{{ $value['name'] }}</li>
      @endif
    @endforeach
  </ol>
</nav>
