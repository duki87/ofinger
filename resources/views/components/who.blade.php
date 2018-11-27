@if(Auth::guard('web')->check())
  <p class="text-success">
    Пријављени сте као <strong>корисник</strong>
  </p>
  @else
  <p class="text-success">
    Одјављени сте као <strong>корисник</strong>
  </p>
@endif

@if(Auth::guard('admin')->check())
  <p class="text-success">
    Пријављени сте као <strong>администратор</strong>
  </p>
  @else
  <p class="text-success">
    Одјављени сте као <strong>администратор</strong>
  </p>
@endif
