<?php
  /*
  ===================================================
  == Manage Categories Page
  == You Can Add | Edit | Delete Members From Here
  ===================================================
  */
  session_start();
  $pageTitle = "Categories";

  if (isset($_SESSION['Username'])) {
    include 'init.php';

    $do = (isset($_GET['do']) && !empty($_GET['do'])) ? $_GET['do'] : 'manage';
    if ($do == 'manage') { // Start Manage Page

    } elseif($do == 'add') { // Start Add Page
?>

      <h1 class="text-center">Add New Category</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=insert" method="post">
          <!-- Start Name -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="name" autocomplete="off" required="required" placeholder="Category Name">
            </div>
          </div>
          <!-- End Name -->

          <!-- Start Description -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="description" placeholder="Category Description">
            </div>
          </div>
          <!-- End Description -->

          <!-- Start Ordering -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10 col-md-8">
              <input type="text" class="form-control" name="ordering" placeholder="Number to arrange the Category">
            </div>
          </div>
          <!-- End Ordering -->

          <!-- Start Visibility -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visibile</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="visibile-yes">
                  <input id="visibile-yes" type="radio" name="visibility" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="visibile-no">
                  <input id="visibile-no" type="radio" name="visibility" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Visibility -->

          <!-- Start Allow Comment -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Comment</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="allow-comment-yes">
                  <input id="allow-comment-yes" type="radio" name="allow_comment" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="allow-comment-no">
                  <input id="allow-comment-no" type="radio" name="allow_comment" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Allow Comment -->

          <!-- Start Allow Ads -->
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-8">
              <div class="radio">
                <label for="allow-ads-yes">
                  <input id="allow-ads-yes" type="radio" name="allow_ads" value="1" checked="checked"> Yes
                </label>
              </div>
              <div class="radio">
                <label for="allow-ads-no">
                  <input id="allow-ads-no" type="radio" name="allow_ads" value="0"> No
                </label>
              </div>
            </div>
          </div>
          <!-- End Allow Ads -->

          <!-- Start Submit -->
          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-4">
              <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Category">
            </div>
          </div>
          <!-- End Submit -->
        </form>
      </div>

<?php
    } elseif($do == 'insert') { // Start Insert Page

      echo "<h1 class='text-center'>Insert New Category</h1>";
      echo "<div class='container'>";

      // Check if User Access to These Page by Post Request
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Variables from the form
        $category_name            = $_POST["name"];
        $category_description     = $_POST["description"];
        $category_ordering        = $_POST["ordering"];
        $category_visibility      = $_POST["visibility"];
        $category_allow_comment   = $_POST["allow_comment"];
        $category_allow_ads       = $_POST["allow_ads"];

        // Validate The form
        $form_errors = array();
        if (empty($category_name)) { $form_errors[] = "<div class='alert alert-danger'>Category name can't be <strong>empty</strong>.</div>"; }
        // Check If Category Name Exist in Database
        if(checkItem("Name", "categories", $category_name)) { $form_errors[] = "<div class='alert alert-danger'>This category name is already <strong>exists</strong>.</div>"; }

        // Check If There's No Error, Proceed The Insert Operation
        if (!empty($form_errors)) :
          // Loop Into Errors Array and Echo It
          redirectHome($form_errors, "back", (count($form_errors) + 2));
        else:
          // Insert Category Info in Database
          $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads)
          VALUES(:name, :description, :ordering, :visibility, :allow_comment, :allow_ads)");
          $stmt->execute(array(
            'name'           => $category_name,
            'description'    => $category_description,
            'ordering'       => $category_ordering,
            'visibility'     => $category_visibility,
            'allow_comment'  => $category_allow_comment,
            'allow_ads'      => $category_allow_ads
          ));

          // Echo Success Message
          $msg = "<div class='alert alert-success'><strong>" . $stmt->rowCount() . "</strong> Record inserted.</div>";
          redirectHome($msg, "back");
        endif;

      } else {
        $msg = "<div class='alert alert-danger'>Your can not browse to this page <strong>directly</strong>.</div>";
        redirectHome($msg);
      }
      echo "</div>";

    } elseif($do == 'edit') { // Start Edit Page

    } elseif($do == 'update') { // Start Update Page

    } elseif($do == 'delete') { // Start Delete Page

    } elseif ($do == 'activate') { // Start Activate Page

    } else { // Start 404 Page

      echo '<h1 class="text-center">Page Not Found! (404)</h1>';

    }

    include $tpl . "footer.php";
  } else {
    header('Location: index.php'); // Redirect To Login Page
    exit();
  }