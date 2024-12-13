<?php
// Inclure le fichier de connexion à la base de données
include 'db_connect.php';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification de la modification d'une réservation
    if (isset($_POST['edit'])) {
        $id_reservation = intval($_POST['id_reservation']); // Renommage du champ id -> id_reservation
        $idmembre = intval($_POST['idmembre']); // Assurez-vous que c'est un nombre entier
        $idactivite = intval($_POST['idactivite']); // Assurez-vous que c'est un nombre entier
        $date_reservation = $_POST['date_reservation']; // Date au format DATETIME
        $statut = $_POST['statut']; // Statut (Confirmée ou Annulée)
        
        // Validation des entrées utilisateur
        if (!empty($date_reservation) && in_array($statut, ['Confirmée', 'Annulée'])) {
            $query = "UPDATE reservations 
                      SET idmembre = ?, idactivite = ?, date_reservation = ?, statut = ? 
                      WHERE id_reservation = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iissi", $idmembre, $idactivite, $date_reservation, $statut, $id_reservation);
            
            if ($stmt->execute()) {
                echo "Réservation mise à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de la réservation : " . $stmt->error;
            }
        } else {
            echo "Les champs sont invalides.";
        }
    }

    // Vérification de la suppression d'une réservation
    if (isset($_POST['delete'])) {
        $id_reservation = intval($_POST['id_reservation']); // Renommage du champ id -> id_reservation
        
        if ($id_reservation > 0) {
            $query = "DELETE FROM reservations WHERE id_reservation = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_reservation);
            
            if ($stmt->execute()) {
                echo "Réservation supprimée avec succès.";
            } else {
                echo "Erreur lors de la suppression de la réservation : " . $stmt->error;
            }
        } else {
            echo "ID de réservation invalide.";
        }
    }
}

// Récupérer toutes les réservations
$query = "SELECT * FROM reservations";
$result = $conn->query($query);

if ($result === false) {
    echo "Erreur lors de la récupération des réservations : " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez une solution de paiement puissante pour les entreprises de logiciels. Simplifiez vos processus, de la caisse au respect des taxes mondiales, avec notre outil innovant et fiable.">
    <meta name="keywords" content="paiement en ligne, solution de paiement, logiciel de paiement, compliance fiscale, taxes mondiales, outil de paiement, entreprises de logiciels, checkout, simplification des paiements">

    <title>ENERGYM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- header -->
    <header class="bg-purple-100">
    <nav class="bg-purple-100 border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
        <img src="../assets/images/energym.png" class="h-8 me-3" alt="energym Logo" />
            <div class="flex items-center lg:order-2">
                <a href="#" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log in</a>
                <a href="#" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Get started</a>
                <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="index.php" class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 dark:text-white" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Company</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Marketplace</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Features</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Team</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- main -->
<main class="m-16">
<h1 class="text-2xl m-16 font-bold mb-4">Gestion des Membres</h1>

<!-- Afficher tous les membres -->
<table class="min-w-full bg-white">
    <thead>
        <tr class="bg-gray-200">
            <th class="py-2">Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // Assurez-vous que $conn est bien une instance PDO
        $stmt = $conn->query("SELECT * FROM membres");
        // $supp = $conn->query("DELETE * FROM membres WHERE id_Membre=id_Membre");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr class='border-b'>
                    <td class='py-2'>{$row['nom']}</td>
                    <td>{$row['prenom']}</td>
                    <td>{$row['mail']}</td>
                    <td>{$row['telephone']}</td>
                    <td>
                        <button  class='text-blue-500'>Modifier</button> |
                        <button onclick='DELETE * FROM membres WHERE id_Membre=1;' class='text-red-500'>Supprimer</button>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>

<!-- parie des activité -->
<h1 class="text-2xl m-16 font-bold mb-4">Gestion des Activités</h1>

<!-- Afficher toutes les activités -->
<table class="min-w-full bg-white">
    <thead>
        <tr class="bg-gray-200">
            <th class="py-2">Nom</th>
            <th>Description</th>
            <th>Capacité</th>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $stmt = $conn->query("SELECT * FROM activite");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr class='border-b'>
                    <td class='py-2'>{$row['nom_Activité']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['capacite']}</td>
                    <td>{$row['date_debut']}</td>
                    <td>{$row['date_fin']}</td>
                    <td>
                        <a href='edit_activite.php?id={$row['id_Activite']}' class='text-blue-500'>Modifier</a> |
                        <a href='delete_activite.php?id={$row['id_Activite']}' class='text-red-500'>Supprimer</a>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>

<!-- Formulaire pour ajouter une activité -->
<h2 class="text-xl m-16 font-bold mt-6">Ajouter une Activité</h2>
<form action="" method="POST" class="bg-gray-100 p-4 rounded">
    <input type="text" name="nom_Activite" placeholder="Nom de l'activité" required class="border p-2 rounded w-full mb-2">
    <textarea name="description" placeholder="Description" required class="border p-2 rounded w-full mb-2"></textarea>
    <input type="number" name="capacite" placeholder="Capacité" required class="border p-2 rounded w-full mb-2">
    <input type="date" name="date_debut" required class="border p-2 rounded w-full mb-2">
    <input type="date" name="date_fin" required class="border p-2 rounded w-full mb-2">
    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Ajouter</button>
</form>

<!-- --------------------------------------reservation---------------------- -->
 <!-- Tableau des réservations -->
 <div class="bg-white p-4 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4">Liste des Réservations</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nom du Membre</th>
                        <th class="px-4 py-2">Id activité</th>
                        <th class="px-4 py-2">date</th>
                        <th class="px-4 py-2">statut</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
$stmt = $conn->query("SELECT * FROM reservations"); 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : 
?>
<tr class="border-t">
    <!-- Affichage des colonnes de la table reservations -->
    <td class="px-4 py-2"><?= htmlspecialchars($row['id_reservation']) ?></td>
    <td class="px-4 py-2"><?= htmlspecialchars($row['idmembre']) ?></td>
    <td class="px-4 py-2"><?= htmlspecialchars($row['idactivite']) ?></td>
    <td class="px-4 py-2"><?= htmlspecialchars($row['date_reservation']) ?></td>
    <td class="px-4 py-2"><?= htmlspecialchars($row['statut']) ?></td>

    <td class="px-4 py-2">
        <!-- Formulaire de modification -->
        <form method="POST" action="" class="inline">
            <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($row['id_reservation']) ?>">
            
            <!-- Sélection de l'ID du membre -->
            <input type="number" name="idmembre" value="<?= htmlspecialchars($row['idmembre']) ?>" class="border p-1 rounded w-28">
            
            <!-- Sélection de l'ID de l'activité -->
            <input type="number" name="idactivite" value="<?= htmlspecialchars($row['idactivite']) ?>" class="border p-1 rounded w-28">
            
            <!-- Date de réservation -->
            <input type="datetime-local" name="date_reservation" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($row['date_reservation']))) ?>" class="border p-1 rounded w-28">
            
            <!-- Sélection du statut de la réservation -->
            <select name="statut" class="border p-1 rounded w-28">
                <option value="Confirmée" <?= $row['statut'] === 'Confirmée' ? 'selected' : '' ?>>Confirmée</option>
                <option value="Annulée" <?= $row['statut'] === 'Annulée' ? 'selected' : '' ?>>Annulée</option>
            </select>
            
            <button type="submit" name="edit" class="bg-green-500 text-white px-2 py-1 rounded">Modifier</button>
        </form>

        <!-- Formulaire de suppression -->
        <form method="POST" action="" class="inline">
            <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($row['id_reservation']) ?>">
            <button type="submit" name="delete" class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>

                </tbody>
            </table>
        </div>
</main>


<!--Footer container-->
<footer class="bg-purple-100  dark:bg-gray-900 bottom-0">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
                  <img src="../assets/images/energym.png" class="h-8 me-3" alt="energym Logo" />
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources</h2>
                  <ul class="text-black dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="https://flowbite.com/" class="hover:underline">Flowbite</a>
                      </li>
                      <li>
                          <a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Follow us</h2>
                  <ul class="text-black dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="https://github.com/themesberg/flowbite" class="hover:underline ">Github</a>
                      </li>
                      <li>
                          <a href="https://discord.gg/4eeurUVvTy" class="hover:underline">Discord</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                  <ul class="text-black-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Privacy Policy</a>
                      </li>
                      <li>
                          <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-black-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. All Rights Reserved.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">
              <a href="#" class="text-gray-900 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a href="#" class="text-gray-900 hover:text-gray-900 dark:hover:text-white ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
                        <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
                    </svg>
                  <span class="sr-only">Discord community</span>
              </a>
              <a href="#" class="text-gray-900 hover:text-gray-900 dark:hover:text-white ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                    <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                </svg>
                  <span class="sr-only">Twitter page</span>
              </a>
              <a href="#" class="text-gray-900 hover:text-gray-900 dark:hover:text-white ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="sr-only">GitHub account</span>
              </a>
              <a href="#" class="text-gray-900 hover:text-gray-900 dark:hover:text-white ms-5">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z" clip-rule="evenodd"/>
                </svg>
                  <span class="sr-only">Dribbble account</span>
              </a>
          </div>
      </div>
    </div>
</footer>

<script src="../assets/js/script1.js"></script>
</body>
</html>