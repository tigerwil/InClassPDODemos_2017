<!-- Articles Page Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Add New Category</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Add Category</li>            
    </ol>
    <!-- end breadcrumb -->

    <?php
        //1.  Check if form was submitted
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            var_dump($_POST);
        
        }
    

    ?>

    <form class="form-inline" method="post" action="addCategory.php">
        <div class="form-group mx-sm-3">
            <label for="category" class="sr-only">Category:</label>
            <input type="text" class="form-control" 
                   id="category" name="category"                    
                    placeholder="Enter the category">
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>
