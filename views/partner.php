<?php
  require_once __DIR__.'/../_.php';
  require_once __DIR__.'/_header.php';

  if (!isset($_SESSION['user']['user_role_name']) || $_SESSION['user']['user_role_name'] !== 'admin'){
    
    if ($_SESSION['user']['user_role_name'] === 'partner' || $_SESSION['user']['user_role_name'] === 'customer'){
        header('Location: profile.php');
    }else{
        header('Location: login.php');
        exit(); // Make sure to exit after sending the header    
    }
  }

  $db = _db();

  if ($_SESSION['user']['user_role_name'] == 'Admin') {
    exit();
  }
  $q = $db->prepare(' SELECT user_id, user_name, user_last_name, user_email, user_tag_color, user_is_blocked
                      FROM users WHERE user_role_name = "partner"');
   $q->execute(); 
  $users = $q->fetchAll();  
                  
?>


<div class="mt-10 pb-20 m-2 bg-white rounded-md">
    <div class="flex py-4 text-xl">
        <h1 class="text-4xl font-bold mb-2">
            All Partners
        </h1>
    </div>

    <?php if( !$users ){ ?>
        <h1>No partners in the system</h1>
        
    <?php }else{?>

        <?php 
            $frm_search_url = 'api-search-partners.php';
        ?>

        <!-- Search form -->
        <form data-url="<?= $frm_search_url ?>" id="frm_search" action="/search-results" method="GET" class="relative flex items-cente ml-auto">
        <input name="query" type="text" class="w-full pl-7 border-4" placeholder="Search first name or last name" oninput="search_partners()"
        onfocus="document.querySelector('#query_results').classList.remove('hidden')"
        onfocus="document.querySelector('#show_orders').classList.add('hidden')"
        onkeydown="return event.key != 'Enter';">
        </form>

        <!-- Users table -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">ID</th>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">First Name</th>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Last Name</th>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Email</th>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Block user</th>
                </tr>
            </thead>

            <!-- Results from search -->
            <tbody id="query_results" class="hidden"></tbody>

            <tbody id="show_users">
                <?php foreach($users as $user): ?>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_id']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_name']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_last_name']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_email']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_is_blocked']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="mt-2 font-bold bg-neutral-200 px-8 py-2" data-id="<?= $user['user_id'] ?>" data-is-blocked="<?= $user['user_is_blocked'] ?>"
                                onclick="block_user(event)">
                                <?= $user['user_is_blocked'] == 0 ? "Unblock" : "Block    " ?>
                            </button>             
                        </td>
                  </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/prevent_enter.js"></script>

<?php
    require_once __DIR__.'/_footer.php';
?>