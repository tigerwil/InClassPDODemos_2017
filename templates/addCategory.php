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
            //var_dump($_POST);
            
            
            $category = trim( filter_var($_POST['category'],FILTER_SANITIZE_STRING));
            
            //Test if user actually entered something
            if(!empty($category)){
                //get our config files and connect to db
                require './includes/config.php';

                require MYSQL;
                
                //build our INSERT statement - using prepared statement
                $stmt = $dbc->prepare("INSERT INTO categories(category)
                                       VALUES (:category)");
                
                //Bind our named parameter :category to user input value
                $stmt->bindValue(':category',$category,PDO::PARAM_STR);
                
                try{
                    //try to execute the query
                    $stmt->execute();
                    echo "<div class='alert alert-success' role='alert'>
                            The category <strong>$category</strong> has been inserted!<br>
                            <a href=''>Add another</a>
                           </div>";
                } catch (Exception $ex) {
                    $code = $ex->getCode();
                    
                    $message = 'Unknow system error!';
                    if ($code == 23000){
                        $message ='You cannot insert a duplicate category!';
                    }
                    //if an error occurs, it will be trapped here
                    echo "<div class='alert alert-danger' role='alert'>
                            The category <strong>$category</strong> was not inserted
                            due to a system error!<br>".
                            $message . 
                            "<p><a href=''>Please try again</a></p>
                            </div>";
                    
                }//end of try catch block
                
                
            }//end if not empty
        
        } else{


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
    
    <?php
    
                
        }//IF POST 
    ?>
        
</div>
