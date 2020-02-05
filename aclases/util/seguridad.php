<?php
class seguridad
{
    private $is_security = 0;

    //0 --> ACTIVADA
    //1 --> DESACTIVADA

    public function callSeguridad()
    {
        if($this->is_security == 0){
            session_start();
            if (!isset($_SESSION['ns_my_key_token'])) // NO EXISTE
            {
                header("Location: ../");
            }

        }else{
            header("Location: ./ ");
        }
    }
}
?>