<div class="row">
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.manage.user') }}">{{ App\User::count() }} tài khoản</a></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.manage.subforum') }}">{{ App\ForumCategories::count() }} diễn đàn con</a></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="media-box">
            <h3><a href="{{ route('admin.manage.post') }}">{{ App\ForumPosts::count() }} bài đăng</a></h3>
        </div>
    </div>
</div>