<!-- Categories Page Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Categories</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Categories</li>            
    </ol>
    <!-- end breadcrumb -->

    <?php
            //1. get the configuration file (holds the connection info)
            require './includes/config.php';

            //2.connect to the database
            require MYSQL;
            //var_dump($dbc);
            
            //3. Get the total number of records in categories table
            $sql = 'SELECT COUNT(*)  FROM categories';
            $stmt = $dbc->query($sql);//execute the query
            
            //get first column from first row in resultset
            $cnt = $stmt->fetchColumn();
            
            //4.  Display total number of categories
            echo "<h2>Total Categories: $cnt</h2>";             
                       
            //5.  Build the SQL Query to retrieve all categories
            $q = "SELECT id, category FROM categories ORDER BY 1";
            
            //6.  Execute the query
            $stmt = $dbc->query($q);
            $category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //var_dump($category_list);
            //exit();
            //start the table
            echo "<table class='table table-bordered table-striped'>
                     <thead class='thead-dark'>
                        <tr>
                            <th>Category</th>
                            <th>Edit</th>
                        </tr>
                     </thead>
                     <tbody>";
            //7.Loop the array and display in ul list
            foreach ($category_list as $row){
                echo "<tr>
                        <td><a href='articlesbycategory.php?id={$row['id']}&name={$row['category']}'>{$row['category']}</a></td>
                        <td>                        
                            <a href='editCategory.php?id={$row['id']}'  title='Edit {$row['category']}'>
                                <i class='fa fa-pencil-square-o fa-2x'></i>
                            </a>
                        </td>
                         
                      </tr>";
            }

            //end the table
            echo "</tbody></table>"
    ?>
    </div>    