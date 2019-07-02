@isset($users)


    <div class="profile-img">
        <img src="{{$users->profile_image}}">
    </div>
    <div class="profile-img">
        <span class="profile-img profile_name">
            {{$users->name}}
        </span>
    </div>
    <div class="profile-img">
        <span class="profile-img profile_name">
            {{$users->email}}
        </span>
    </div>
    <div class="profile-img">
        <a href="{{ route('users.edit', $users->id) }}">Edit</a>
    </div>

{{--    <table class="table-users">--}}
{{--        <tr>--}}
{{--            <td>Profile Picture</td>--}}
{{--            <td>Name</td>--}}
{{--            <td>Email</td>--}}
{{--            <td>Actions</td>--}}
{{--        </tr>--}}
{{--            <tr>--}}
{{--                <td class="profile-table"><img src="{{$users->profile_image}}"></td>--}}
{{--                <td><a href="{{ route('users.show', $users->id) }}">{{$users->name}}</td>--}}
{{--                <td>{{$users->email}}</td>--}}
{{--                <td>--}}
{{--                        <a href="{{ route('users.edit', $users->id) }}">Edit</a>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--    </table>--}}

@endisset