<!doctype html>
<html lang="en">
<head>
    <title>Giphy</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <h1>GIF COLLECTION</h1>

    <div class="center">
        <div class="menu">
            <div class="search">
                <h2>Find a GIF you're looking for</h2>
                <form action="view.php" method="post">
                    <label for="byName">Title: </label>
                    <input type="text" id="byName" name="byName" required><br><br>
                    <label for="perPage">Limit: </label>
                    <input type="number" id="perPage" name="perPage" required><br><br>
                    <input type="submit" name="search" value="Submit"><br><br>
                </form>
            </div>

            <h2>Or check out</h2>

            <div class="trending">
                <input type="submit" name="trending" value="Trending GIFS"><br><br>
            </div>
        </div>
    </div>

</body>
</html>