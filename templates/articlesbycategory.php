<?php
if (isset($_GET['name'])) {
    $name = $_GET['name'];
} else {
    $name = 'Articles by Category';
}
?>

<!-- ArticlesByCategogy Page Content -->
<div class="container">
    <h1 class="mt-4 mb-3"><?php echo $name; ?></h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href='categories.php'>Categories</a></li>  
        <li class="breadcrumb-item active"><?php echo $name; ?></li>
    </ol>
    <!-- end breadcrumb -->
    <?php
    //1. Retrieve the id parameter from the url querystring
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $catid = $_GET['id'];

        //2.  get the database configuration file
        require './includes/config.php';

        //3.  connect to the database
        require MYSQL;

        //4.  Build the sql query -using PDO prepared statement
        $stmt = $dbc->prepare("SELECT id, title, description
                                   FROM pages
                                   WHERE category_id=:catid");

        //Bind the parameter
        $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);

        //5.  Execute the query
        $stmt->execute();

        //6.  Fetch the records
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($articles);

        echo   '<div class="row">';
        //  Loop the articles array - and display each as a card  within 3 column grid     
            foreach($articles as $row){
                ?>
                 <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header"><?php echo $row['title']?></h4>
                        <div class="card-body">
                            <p class="card-text"><?php echo $row['description']?></p>
                        </div>
                        <div class="card-footer">
                            <a href="article.php?id=<?php echo $row['id']?>" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>  
           <?php
            }

              echo   '</div>';

    } else {
        ?>
        <div class="alert alert-warning" role="alert">
            This page has been accessed in error!<br>
            <a class='btn btn-warning' href='categories.php'>View all Categories</a>
        </div>

    <?php
}
?>
</div>