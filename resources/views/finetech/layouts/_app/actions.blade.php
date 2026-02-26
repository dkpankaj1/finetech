  <form action="{{ route('finetech.logout') }}" method="post" id="adminLogoutForm">
      @csrf
  </form>
  <form action="{{ route('finetech.themes.toggle') }}" method="post" id="themesToggleForm">
      @csrf
  </form>
