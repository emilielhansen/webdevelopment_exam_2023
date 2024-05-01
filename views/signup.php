<?php 
    require_once __DIR__.'/../_.php';
    require_once __DIR__.'/_header.php';  
?>

<div class="max-w-md w-full p-8 shadow-md mx-auto bg-neutral-800 mt-10">
        <form onsubmit="validate(event, signup); return false;">
            <h1 class="text-4xl mb-4 text-white font-bold">
                Become a customer
            </h1>
            <!-- User Name -->
            <div class="mb-2">
                <label for="user_name" class="block text-white font-bold">First name</label>
                <span class="ml-auto text-white">Enter <?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters</span>
                <input id="user_name" name="user_name" type="text" class="border-2 w-full px-3 py-2" 
                    data-validate="str" data-min="<?= USER_NAME_MIN ?>" data-max="<?= USER_NAME_MAX ?>"
                    placeholder="Enter first name">
            </div>

            <!-- User Last Name -->
            <div class="mb-2">
                <label for="user_last_name" class="block text-white font-bold">Last name</label>
                <span class="ml-auto text-white">Enter <?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters</span>
                <input id="user_last_name" name="user_last_name" type="text" class="border-2 w-full px-3 py-2" 
                    data-validate="str" data-min="<?= USER_LAST_NAME_MIN ?>" data-max="<?= USER_LAST_NAME_MAX ?>"
                    placeholder="Enter last name">
            </div>

            <!-- User address -->
            <div class="mb-2">
                <label for="user_address" class="block text-white font-bold">Address</label>
                <span class="ml-auto text-white">Enter <?= USER_ADRESS_MIN ?> to <?= USER_ADRESS_MAX ?> characters</span>
                <input id="user_address" name="user_address" class="border-2 w-full px-3 py-2" type="text" 
                    placeholder="Enter adress">
            </div>
            
            <!-- User Email -->
            <div class="mb-2">
                <label for="user_email" class="block text-white font-bold">Email</label>
                <span class="ml-auto text-white">Enter a valid email not in use</span>
                <input id="user_email" name="user_email" class="border-2 w-full px-3 py-2" type="text" 
                    onblur="is_email_available()"
                    onfocus='document.querySelector("#msg_email_not_available").classList.add("hidden")'
                    data-validate="email"
                    placeholder="Enter email">

                    <div id="msg_email_not_available" class="hidden text-red-500 font-bold">
                    Email is not available, choose a valid one
                </div>
            </div>

            <!-- User Password -->
            <div class="mb-2">
                <label for="user_password" class="block text-white font-bold">Password</label>
                <span class="ml-auto text-white">Enter <?= USER_PASSWORD_MIN ?> to <?= USER_PASSWORD_MAX ?> characters</span>
                <input id="user_password" name="user_password" class="border-2 w-full px-3 py-2" type="password" 
                    data-validate="str" data-min="<?= USER_PASSWORD_MIN ?>" data-max="<?= USER_PASSWORD_MAX ?>"
                    placeholder="Enter password">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="mt-2 font-bold bg-neutral-200 px-8 py-2">Signup</button>
        </form>

    <!-- Go back button -->
    <p class="text-white mt-2"> Already have a user? <a href="/views/login.php" class="font-bold">Login</a></p>
    <p class="text-white">or</p>
    <p><a href="/views/signup_partner.php" class="font-bold text-white">Become a partner</a></p>
</div>

<?php require_once __DIR__.'/_footer.php' ?>
