<?php
//nincs használva

function mod_menu($conn){
echo'
<div class="col-lg-6">
    <div class="card mb-4">
        <div class="card-header">
        <i class="fa-solid fa-pen"></i>
            Módositás
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="inputModify"  class="form-label">Módositandó adat</label>
                    <select id="md_select" name="md_value" onChange="modif_switch()" class="form-select">
                        <option value=""></option>
                        ';
                        select_mod($conn);
                        echo'
                    </select>
                    <div class="form-check form-switch">
                        <label for="inputcheck" class="form-check-label">Módositás</label>
                        <input class="form-check-input" type="checkbox" id="inputcheck" onclick="sub_text()" name="md_check" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer small text-muted">
            A módositandó vevőt válaszd ki a módositásához. Ha nem szeretnéd mégsem módositani akkor váltsd vissza a switchet.
        </div>
    </div> 
</div>';
}

?>