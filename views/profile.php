<!-- Customer page -->

<?php
require_once __DIR__.'/../_.php';
require_once __DIR__.'/_header.php';  

try {

    if (!isset($_SESSION['user']['user_role_name'])){
        header('Location: login.php');
        exit(); // Make sure to exit after sending the header
    }

    // Connect to the database
    $db = _db();

    // Get user information based on user role
    if ($_SESSION['user']['user_role_name'] !== 'Admin') {
        $user_id = $_SESSION['user']['user_id']; 
    } else {
        // For admin, set user_id to a placeholder (['user_id'])
        $user_id = ['user_id'];
    }

    // Fetch user data from the database
    $q = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $q->bindValue(':user_id', $user_id);
    $q->execute();
    $user = $q->fetch();
} catch (Exception $e) {
    // Handle exceptions and set appropriate HTTP response code
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
?>

<div class="max-w-md w-full p-8 shadow-md mx-auto bg-neutral-800 mt-10">
    <div class="flex flex-col">
        <!-- Display user information -->
        <p class="text-white mt-1 mb-1 font-bold">Full Name</p> <p class="text-white mt-1 mb-1"><?= $user['user_name'] ?> <?= $user['user_last_name'] ?></p>
        <p class="text-white mt-1 mb-1 font-bold">Email</p><p class="text-white mt-1 mb-1"><?= $user['user_email'] ?></p>
    </div>

    <div class="flex mt-4 justify-start">
        <button id="openModalBtn" class="mt-2 font-bold bg-neutral-200 px-8 py-2">Edit user</button>

        <!-- User edit modal -->
        <div id="my_modal" class="modal hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50">
            <div class="modal-content mx-auto my-8 p-6 bg-neutral-800 shadow-lg w-96">
                <!-- Close modal button -->
                <span class="close cursor-pointer absolute top-0 right-0 p-4 text-white">&times;</span>

                <!-- Header -->
                <h1 class="text-lg text-white font-bold">Update user</h1>

                <!-- User edit form -->
                <form onsubmit="validate(event, update_user);">
                    <input class="hidden" name="user_id" type="text" value="<?= $user['user_id'] ?>">
                    <label for="user_email" class="block text-white font-bold">New email</label>
                    <input type="email" id="user_email" name="user_email" placeholder="Enter email" class="w-full py-2 px-3 mb-2"
                    onblur="is_email_available()"
                    onfocus='document.querySelector("#msg_email_not_available").classList.add("hidden")'
                    data-validate="email">

                        <div id="msg_email_not_available" class="hidden text-red-500 font-bold">
                         Email is not available, choose a valid one
                        </div>
                    

                    <input class="hidden" name="user_id" type="text" value="<?= $user['user_name'] ?>">
                    <label for="user_name" class="block text-white font-bold">New First name</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter name" class="w-full py-2 px-3 mb-2" required>
                    <p class="mb-2 text-white">Every field must be filled out</p>
                    <button type="submit" class="mt-2 font-bold bg-neutral-200 px-8 py-2">Update user</button>
                </form>
            </div>
        </div>

        <!-- Delete user form -->
        <form onsubmit="delete_user(); return false">
            <input class="hidden" name="user_id" type="text" value="<?= $user['user_id'] ?>">
            <button class="mt-2 font-bold bg-neutral-200 px-8 py-2 mx-4">Delete user</button>
        </form>
    </div>
</div>

<!-- Include Modalbox javascript -->
<script src="/../js/modal.js"></script>

<?php require_once __DIR__.'/_footer.php' ?>