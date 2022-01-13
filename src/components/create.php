<div class="create">
    <form action="/instagram/publish" method="post" enctype="multipart/form-data">

        <textarea class="form-control mb-2" name="title" rows="3"></textarea>

        <div class="d-flex justify-content-between">
            <input type="file" class="w-50" name="image" accept="image/png, image/jpeg">
            <input type="submit" class="btn btn-primary w-25" value="Post">
        </div>
    </form>
</div>