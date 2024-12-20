<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-light leading-tight">
      Perfil
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="container-lg space-y-6">
      <!-- Update Profile Information -->
      <div class="card bg-light my-4 text-dark">
        <div class="card-body">
          @include('profile.partials.update-profile-information-form')
        </div>
      </div>

      <!-- Update Password -->
      <div class="card bg-light my-4 text-dark">
        <div class="card-body">
          @include('profile.partials.update-password-form')
        </div>
      </div>

      <!-- Delete User -->
      <div class="card bg-light my-4 text-dark">
        <div class="card-body">
          @include('profile.partials.delete-user-form')
        </div>
      </div>
    </div>
  </div>
</x-app-layout>