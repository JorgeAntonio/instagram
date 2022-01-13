<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>

<?php require_once 'src/components/menu.php' ?>

<div class="container w-25">
    <h2 class="mt-3">Profile <?php echo $this->d['user']->getUsername(); ?></h2>

    <?php
    $user = $this->d['user'];
    $posts = $user->getPosts();

    foreach ($posts as $p){ ?>

        <div class="card mt-2">
            <div class="card-body">
                <img class="rounded-circle" src="./public/img/photos/<?php echo $p->getUser()->getProfile() ?>" width="10%" />
                <?php echo $p->getUser()->getUsername() ?>
                <p class="card-text mt-3"><?php echo $p->getTitle() ?></p>
            </div>
            <img src="./public/img/photos/<?php echo $p->getImage() ?>" width="100%" />
            <div class="card-body">
                <div class="card-title">
                    <form action="/instagram/addlike" method="POST">
                        <input type="hidden" name="post_id" value="<?php echo $p->getId() ?>">
                        <input type="hidden" name="origin" value="profile/<?php echo $user->getUsername() ?>">
                        <button type="submit" class="btn btn-danger"><?php echo $p->getLikes(); ?> Likes</button>
                    </form>
                </div>
            </div>
        </div>
        <br>

    <?php } ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>