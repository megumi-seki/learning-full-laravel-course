@props(["bodyClass" => "", "title" => "", "socialAuth" => true])

<x-base-layout :$bodyClass :$title>
    <main>
        <div class="container-small page-login">
          <div class="flex" style="gap: 5rem">
            <div class="auth-page-form">
              <div class="text-center">
                <a href="/">
                  <img src="/img/logoipsum-265.svg" alt="" />
                </a>
              </div>

              @session("success")
                <div class="my-large">
                 <div class="success-message">
                    {{ session("success") }}
                 </div>
                </div>
              @endsession
                {{ $slot }}
                
                @if ($socialAuth)
                  <div class="grid grid-cols-2 gap-1 social-auth-buttons">
                    <x-google-button />
                    <x-facebook-button />
                  </div>           
                @endif
                @isset($footerLink)
                  <div class="login-text-dont-have-account">
                    {{ $footerLink }}
                  </div>
                @endisset
            </div>
            <div class="auth-page-image">
              <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
            </div>
          </div>
        </div>
    </main>
</x-base-layout>
