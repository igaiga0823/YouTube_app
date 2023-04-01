

    <?php 
        session_start();
        $user = $_SESSION['user_id'];
        if (!isset($user)){
            ?>
            <script>        
            setTimeout(function(){
                window.location.href = '../index.php';
            }, -1);</script>
            <?php
        }

    ?>
