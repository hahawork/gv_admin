<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        if ($NivelAcceso == 1) {
            $selecclientes = "SELECT * FROM `clientes`";
        }
        if ($NivelAcceso == 3) {
            $selecclientes = "SELECT * FROM `clientes`";
        }
        if ($NivelAcceso == 4) {
            $selecclientes = "SELECT * FROM `clientes`";
        }

        if ($resultClientes = mysqli_query($conn, $selecclientes)) {
            while ($row = mysqli_fetch_assoc($resultClientes)) {
                $id = $row["IdCliente"];
                ?>
                <li class="<?php echo $id == 1 ? "active" : "" ?>"><a href="#tab_<?php echo $id ?>" data-toggle="tab"><?php echo $row["RazonSocial"] ?></a></li>
                <?php
            }
        }
        ?>       
        <div class="tab-content">

            <div class="tab-pane active" id="tab_<?php echo $id ?>">

                
                <b>How to use:</b>

                <p>Exactly like the original bootstrap tabs except you should use
                    the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                A wonderful serenity has taken possession of my entire soul,
                like these sweet mornings of spring which I enjoy with my whole heart.
                I am alone, and feel the charm of existence in this spot,
                which was created for the bliss of souls like mine. I am so happy,
                my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                that I neglect my talents. I should be incapable of drawing a single stroke
                at the present moment; and yet I feel that I never was a greater artist than now.
            </div>
            <!-- /.tab-pane -->            
        </div>
        <!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->