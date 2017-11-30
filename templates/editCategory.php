<!-- Articles Page Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Edit Category</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="categories.php">Categories</a></li>
        <li class="breadcrumb-item active">Edit Category</li>            
    </ol>
    <!-- end breadcrumb -->

    <?php
        //1.  Must retrieve a url parameter called id
        //var_dump($_GET);
        //exit();
        if ( isset($_GET['id'])  && is_numeric($_GET['id']) ){
            //For GET
            //if we get here, we found our id parameter and it's numeric
            //store it in variable for later use
            $id = $_GET['id']; 
        }elseif( isset($_POST['id']) && is_numeric($_POST['id'])  ){
            //FOR POST
            //if we get to this area, the user has posted -
            //need to retrieve the id from hidden post field
            $id=$_POST['id'];
        }else{
            //Parameter is missing - kill the script
            //and show error message
            echo '<div class="alert alert-danger" role="alert">
                    This page has been accessed in error!
                    <p><a class="btn btn-warning" href="categories.php">Select a Category</a></p>
                 </div>';
            //complete proper closing html
            echo '</div>';
            include './includes/footer.php';
            exit();
        }
    
        //Good to go - we have our id parameter 
        //let's connect to the database
        require './includes/config.php';
        require MYSQL;    
        
        //1.  Check if form was submitted
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            //var_dump($_POST);
            $category = trim( filter_var($_POST['category'],FILTER_SANITIZE_STRING));
            
             //Test if user actually entered something
            if(!empty($category)){
               //Build the prepared statement for the UPDATE
                $stmt=$dbc->prepare("UPDATE categories 
                                      SET category =:category
                                      WHERE id = :id
                                      LIMIT 1");
                //Bind the 2 parameters to the variables
                $stmt->bindValue(':category',$category,PDO::PARAM_STR);
                $stmt->bindValue(':id',$id,PDO::PARAM_INT);
                
                //Execute the statement
                try{
                    $stmt->execute();
                    echo "<div class='alert alert-success' role='alert'>
                            The category <strong>$category</strong> has been updated!
                          </div>";
                    
                } catch (Exception $ex) {
                    echo "<div class='alert alert-danger' role='alert'>
                            Error updating the category <strong>$category</strong>!<br>".
                            $ex->getMessage().                         
                          "</div>";          
                }
            }
            
            
        }//END OF POST PROCESSING
        
        $q = "SELECT category FROM categories WHERE id=$id";
        $stmt= $dbc->query($q);
        $row=$stmt->fetchColumn();
        
        //test if we have anything returned
        if($row){
            //found our category
            //var_dump($row);   
            //Create the HTML form
       ?>
       <form class="form-inline" method="post" action="editCategory.php">
        <div class="form-group mx-sm-3">
            <label for="category" class="sr-only">Category:</label>
            <input type="text" class="form-control" 
                   id="category" name="category"                    
                   value="<?php echo $row;?>">
        </div>
           <input type="hidden" name="id" id="id" value="<?php echo $id?>">
        <button type="submit" class="btn btn-primary">Edit Category</button>
      </form>
    <?php
        }else{
            //if we get here, id was not found 
            //ie user manually entered id=1000 in the url
           echo '<div class="alert alert-warning" role="alert">
                    This is an invalid category! <br>
                    <a href="categories.php">Select a Category</a>
                  </div>'; 
        } 
        //exit();
    ?>
</div>