<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  @includeFirst(['emails.style', 'iprofile::emails.base.style'])

</head>

<body>
<div id="body">
  <div id="template-mail">

    @includeFirst(['emails.header', 'iprofile::emails.base.header'])

    {{-- ***** Order Content  ***** --}}
    <div id="contend-mail" class="p-3">
      
      {{-- ***** Title  ***** --}}
      <h3 class="text-center text-uppercase">
        {{trans('iprofile.profiles.messages.Update Profile')}}
      </h3>
      
      <br>
      <p class="px-3">
        <strong>Mr/Mrs:</strong>
        {{$user->first_name}} {{$user->last_name}}<br>
      </p>

      <div style="margin-bottom: 5px">
        <p class="px-3">
          {{trans('iprofile.profiles.messages.It has been 6 months since you last updated the profile')}}
        </p>
        <p class="px-3">
          {{trans('iprofile.profiles.To avoid problems with your account and denial of permission please update it in your application')}}
        </p>
      </div>
      <br>
    </div>


    @includeFirst(['emails.footer', 'iprofile::emails.base.footer'])


  </div>
</div>
</body>

</html>