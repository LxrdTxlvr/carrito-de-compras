<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "carro-compras");

if (isset($_POST["add_to_cart"])) {
    // ...
}

if (isset($_GET["action"])) {
    // ...
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Carrito de compras</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                <a href="usuario.html" class="btn btn-primary" style="margin-left: 10px;">Iniciar sesión</a>
            </div>
        </div>
    </nav>
    <main class="container">
        <br />
        <div class="container">
            <br />
            <br />
            <br />
            <h3 align="center"><a href="https://www.configuroweb.com/" title="Para más desarrollos ConfiguroWeb" style="color:white;text-decoration:none;">Seleccione los productos que desea comprar</a></h3><br />
            <br /><br />
            <?php
            $query = "SELECT * FROM tbl_product ORDER BY id ASC";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <div class="col-md-4">
                        <form method="post" action="prub.php?action=add&id=<?php echo $row["id"]; ?>">
                            <div class="product-card">
                                <img src="images/<?php echo $row["image"]; ?>" alt="<?php echo $row["name"]; ?>" class="img-responsive">
                                <h4 class="product-name"><?php echo $row["name"]; ?></h4>
                                <h4 class="product-price">$ <?php echo $row["price"]; ?></h4>
                                <input type="text" name="quantity" value="1" class="form-control">
                                <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                                <input type="submit" name="add_to_cart" class="btn btn-warning" value="Agregar Producto">
                            </div>
                        </form>
                    </div>
            <?php
                }
            }
            ?>
            <div style="clear:both"></div>
            <br />
            <h3>Información de la Orden</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nombre del Producto</th>
                        <th width="10%">Cantidad</th>
                        <th width="20%">Precio</th>
                        <th width="15%">Total</th>
                        <th width="5%">Acción</th>
                    </tr>
                    <?php
                    if (!empty($_SESSION["shopping_cart"])) {
                        $total = 0;
                        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    ?>
                            <tr>
                                <td><?php echo $values["item_name"]; ?></td>
                                <td><?php echo $values["item_quantity"]; ?></td>
                                <td>$ <?php echo $values["item_price"]; ?></td>
                                <td style="color:black">$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
							<td style="color:black"><a href="prub.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Quitar Producto</span></a></td>
						</tr>
					<?php
						$total = $total + ($values["item_quantity"] * $values["item_price"]);
					}
					?>
					<tr>
						<td colspan="3" align="right" style="color:white;">Total</td>
						<td align="right" style="color:white;">$ <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
				<?php
				}
				?>

			</table>
		</div>
	</div>
	</div>
	<br />
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>