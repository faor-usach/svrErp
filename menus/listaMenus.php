
<div class="row" style="padding: 10px;">

    <div class="col-xl-7">
        <div class="card">

            <div class="card-header"><b>Menú</b></div>
            <div class="card-body">

                <table id="usuarios" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#          </th>
                            <th>Menú       </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQL = "SELECT * FROM menugrupos Order By nMenu";
                            $firstMenu = '';

                            if(isset($_POST['nMenu']))           { $firstMenu = $_POST['nMenu'];   }
                            if(isset($_POST['EliminarMenu']))    { $firstMenu = '';                   }

                            $bd=$link->query($SQL);
                            while ($row=mysqli_fetch_array($bd)){
                                if($firstMenu == ''){
                                    $firstMenu = $row['nMenu'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['nMenu']; ?>  </td>
                                    <td>
                                        <?php 
                                            echo $row['nomMenu'];
                                            $modulos = '';
                                            $SQLmm = "SELECT * FROM menuitems Where nMenu = '".$row['nMenu']."' Order By nModulo";
                                            $bdmm=$link->query($SQLmm);
                                            while ($rowmm=mysqli_fetch_array($bdmm)){
                                                $SQLmo = "SELECT * FROM modulos Where nModulo = '".$rowmm['nModulo']."'";
                                                $bdmo=$link->query($SQLmo);
                                                if ($rowmo=mysqli_fetch_array($bdmo)){
                                                    if($modulos){ 
                                                        $modulos .= ', '.$rowmo['Modulo'];
                                                    }else{
                                                       $modulos .= $rowmo['Modulo']; 
                                                    }
                                                    
                                                    //echo $rowmo['Modulo'];
                                                }
                                            }
                                            if($modulos){
                                                echo '<br><b>('.$modulos.')</b>';
                                            }
                                        ?>   
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-info" href="index.php?nMenu=<?php echo $row['nMenu']; ?>">Ver</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            $link->close();
                            ?>
                    </tbody>
                </table>      
            </div> 
            <div class="card-footer">
                

            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <?php
            if(isset($_GET['Accion']) == 'Agregar'){
                if(isset($_POST['GuardarMenu'])){?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> REGISTRO AGREGADO CON EXITO ...
                    </div>                      
                <?php 
                }
                ?>
               <form action="index.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <b>Nuevo Menú</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="nMenu">Id Menú:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nMenu" name="nMenu" placeholder="Id Menú" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="Perfil">Menú:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nomMenu" name="nomMenu" placeholder="Nombre del Menú" required />
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarMenu" class="btn btn-primary">
                            Guardar
                        </button>
                    </div>
                </div>
                </form>
 


                <?php
            }else{

            if(isset($_GET['nMenu'])){ $firstMenu = $_GET['nMenu']; }

            $link=Conectarse();
            $SQL = "SELECT * FROM menugrupos where nMenu = '".$firstMenu."'";
            
            $bd=$link->query($SQL);
            if ($row=mysqli_fetch_array($bd)){
                if(isset($_POST['GuardarMenu'])){?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Exito!</strong> REGISTRO GUARDADO CON EXITO ...
                    </div>                      
                <?php 
                }
                ?>
                <form action="index.php" method="post">
                <div class="card">
                    <div class="card-header">
                        <?php echo $row['nomMenu']; ?>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="nMenu">Id Menú:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nMenu" name="nMenu" value="<?php echo $row['nMenu']; ?>" placeholder="Id del Menú" autofocus required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <label for="Perfil">Nombre Menú:</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nomMenu" name="nomMenu" value="<?php echo $row['nomMenu']; ?>" placeholder="Nombre del Menú" required />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" name="GuardarMenu" class="btn btn-primary">
                            Guardar
                        </button>
                         <button type="submit" name="EliminarMenu" class="btn btn-warning">
                            Eliminar
                        </button>
                       
                    </div>
                </div>
                </form>
                <?php
            }
            $link->close();
        }
        ?>
        <br>
        
        <div class="card">
            <div class="card-header"><b>Módulos Asociados a <?php echo $row['nomMenu']; ?></b></div>
            <div class="card-body">

                <form action="index.php" method="post">
                <div class="card" style="padding: 5px;">
                    
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-10">
                            <div class="form-group">
                            <input name="nMenu" type="hidden" value="<?php echo $firstMenu; ?>" />
                            <label for="sel1">Agregar Módulo a <?php echo $row['nomMenu']; ?>:</label>
                            <select class="form-control" id="nModulo" name="nModulo">

                                <?php
                                    $link=Conectarse();
                                    $SQLmp = "SELECT * FROM modulos Order By Modulo Asc";
                                    $bdmp=$link->query($SQLmp);
                                    while ($rowmp=mysqli_fetch_array($bdmp)){
                                        $SQLm = "SELECT * FROM menuitems Where nModulo = '".$rowmp['nModulo']."' and nMenu = '$firstMenu'";
                                        $bdm=$link->query($SQLm);
                                        if ($rowm=mysqli_fetch_array($bdm)){
                                        }else{?>
                                            <option value="<?php echo $rowmp['nModulo']; ?>"><?php echo $rowmp['Modulo']; ?></option>
                                            <?php
                                        }
                                    }
                                    $link->close();
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-1">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-10">
                            
                            <button type="submit" name="agregarModulo" class="btn btn-primary btn-block">
                                Agregar Módulo a <?php echo $row['nomMenu']; ?>
                            </button>
                            
                        </div>
                        <div class="col-1">
                        </div>

                    </div>
                </div>
                </form>
                <br>

                <table id="modulos" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>#          </th>
                            <th>Módulos       </th>
                            <th>Acciones    </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $link=Conectarse();
                            $SQLmp = "SELECT * FROM menuitems where nMenu = '$firstMenu' Order By nModulo Asc";
                            $firstMenu = '';

                            if(isset($_POST['nModulo']))            { $nModulo = $_POST['nModulo'];   }

                            $bdmp=$link->query($SQLmp);
                            while ($rowmp=mysqli_fetch_array($bdmp)){?>
                                <tr>
                                    <td><?php echo $rowmp['nModulo']; ?>  </td>
                                    <td>
                                        <?php 
                                            $SQLm = "SELECT * FROM modulos Where nModulo = '".$rowmp['nModulo']."'";
                                            $bdm=$link->query($SQLm);
                                            if($rowm=mysqli_fetch_array($bdm)){
                                                echo $rowm['Modulo'];
                                            } 
                                        ?>   
                                    </td>
                                    <td>
                                        <a type="button" class="btn btn-warning" href="index.php?nMenu=<?php echo $row['nMenu']; ?>&nModulo=<?php echo $rowm['nModulo']; ?>&accion=Quitar">Quitar</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            $link->close();
                            ?>
                    </tbody>
                </table> 



            </div>
        </div>
        



    </div>
</div>
