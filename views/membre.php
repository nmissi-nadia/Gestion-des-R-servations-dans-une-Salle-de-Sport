<?php 
include "db_connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Vérification si tous les champs requis pour la réservation sont présents et non vides
        if (!empty($_GET['id_activite'])) {
            
            // Sécuriser les entrées utilisateurs (protection XSS)
            // $id_membre = (int) $_POST['id_membre'];
            $id_membre = 1;
            $id_activite = (int) $_GET['id_activite'];
        
            // Insertion dans la table des réservations
            $stmt = $conn->prepare("INSERT INTO reservations (idmembre, idactivite) 
                                    VALUES (:id_membre, :id_activite)");
            $stmt->execute([
                ':id_membre' => $id_membre,
                ':id_activite' => $id_activite
            ]);

            // Affichage du message de confirmation
            echo "<script>
                    alert('Réservation réussie !');
                  </script>";

        } else {
            echo "<script>alert('Veuillez remplir tous les champs de la réservation.');</script>";
        }

    } catch (PDOException $e) {
        // Affichage de l'erreur s'il y a un problème de connexion ou d'insertion
        echo "<script>alert('Erreur lors de la réservation : " . $e->getMessage() . "');</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérification si tous les champs sont présents et non vides
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['telephone'])) {
            
            // Sécuriser les entrées utilisateurs (protection XSS)
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $mail = htmlspecialchars(trim($_POST['mail']));
            $telephone = htmlspecialchars(trim($_POST['telephone']));

            // Validation de l'email
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Veuillez entrer un email valide.');</script>";
                exit;
            }

            // Insertion dans la table des membres
            $stmt = $conn->prepare("INSERT INTO membres (nom, prenom, mail, telephone) 
                                    VALUES (:nom, :prenom, :mail, :telephone)");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':mail' => $mail,
                ':telephone' => $telephone
            ]);

            // Affichage du message de confirmation et appel de la fonction pour afficher le formulaire d'activités
            echo "<script>
                    alert('Inscription réussie ! Vous pouvez maintenant réserver des activités.');
                    showActivityForm();
                  </script>";

        } else {
            echo "<script>alert('Veuillez remplir tous les champs du formulaire du membre.');</script>";
        }

    } catch (PDOException $e) {
        // Affichage de l'erreur s'il y a un problème de connexion ou d'insertion
        echo "<script>alert('Erreur lors de l\'insertion des données : " . $e->getMessage() . "');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez une solution de paiement puissante pour les entreprises de logiciels. Simplifiez vos processus, de la caisse au respect des taxes mondiales, avec notre outil innovant et fiable.">
    <meta name="keywords" content="paiement en ligne, solution de paiement, logiciel de paiement, compliance fiscale, taxes mondiales, outil de paiement, entreprises de logiciels, checkout, simplification des paiements">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>SALLE DU SPORT</title>
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
<?php 

include('db_connect.php');
?>


<div class="container mx-auto mt-10 p-5">
        <!-- Section de choix -->
        <div id="choice-section" class="flex justify-center gap-8">
            <div onclick="showConnexionForm()" class="w-1/4 bg-blue-500 text-white p-10 rounded-lg text-center cursor-pointer hover:bg-blue-700 transition">
                <h2 class="text-xl font-bold">Connexion</h2>
            </div>
            <div onclick="showActivityForm()" class="w-1/4 bg-green-500 text-white p-10 rounded-lg text-center cursor-pointer hover:bg-green-700 transition">
                <h2 class="text-xl font-bold">Déjà Connecté</h2>
            </div>
        </div>

        <!-- Formulaire de connexion -->
        <div id="connexion-form" class="hidden flex-column flex justify-center mt-10">
            <h2 class="text-2xl font-bold mb-5">Formulaire de Connexion</h2>
            <form id="membreForm" action="membre.php" method="POST" class="bg-purple-200 w-[500px]  p-8 shadow-md rounded-lg">
                <label class="block mb-4">
                    <span class="block text-gray-700">Nom</span>
                    <input type="text" name="nom" class="w-full mt-1 p-2 border rounded" required>
                </label>
                <label class="block mb-4">
                    <span class="block text-gray-700">Prénom</span>
                    <input type="text" name="prenom" class="w-full mt-1 p-2 border rounded" required>
                </label>
                <label class="block mb-4">
                    <span class="block text-gray-700">Email</span>
                    <input type="email" name="mail" class="w-full mt-1 p-2 border rounded" required>
                </label>
                <label class="block mb-4">
                    <span class="block text-gray-700">Téléphone</span>
                    <input type="tel" name="telephone" class="w-full mt-1 p-2 border rounded" required>
                </label>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-700">S'inscrire</button>
            </form>
        </div>

        <!-- Formulaire des activités -->
        <div id="activity-form" class="block mt-10">
    <h2 class="text-2xl font-bold mb-5">Formulaire de Réservation d'Activités</h2>
    
    <!-- Formulaire de réservation -->
    <form id="activityForm" action="membre.php" method="GET" class="bg-white p-8 shadow-md rounded-lg">
        
        <!-- Sélection de l'activité -->
        <label class="block mb-4">
            <span class="block text-gray-700">Choisissez une activité</span>
            <select name="id_activite" id="activiteSelect" class="w-full mt-1 p-2 border rounded" onchange="afficherDescription()">
                <option value="" disabled selected>-- Sélectionnez une activité --</option>
                <?php 
                    include "db_connect.php";
                    $result = $conn->query("SELECT id_Activite, nom_Activité, description FROM activite");
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id_Activite'] . "' data-description='" . htmlspecialchars($row['description'], ENT_QUOTES) . "'>" . $row['nom_Activité'] . "</option>";
                    }
                ?>
            </select>
        </label>

        <!-- Affichage de la description de l'activité -->
        <div id="activity-description" class="mt-4 p-4 bg-gray-100 rounded text-gray-800"></div>

        <!-- Bouton de soumission -->
        <button type="submit" name="reserver" class="bg-green-500 text-white p-2 rounded hover:bg-green-700 w-full mt-4">
            Réserver
        </button>
    </form>
</div>

<!-- Affichage des réservations de l'utilisateur -->
<div id="reservations" class="block mt-10">
    <h2 class="text-2xl font-bold mb-5">Vos Réservations</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2">ID Réservation</th>
                <th>Nom de l'Activité</th>
                <th>Date de Réservation</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                // On suppose que l'id du membre est défini dans $_SESSION['idmembre']
                $idmembre = 1; // Remplacez par $_SESSION['idmembre'] si session active
                $reservations = $conn->prepare("SELECT r.id_reservation, a.nom_Activité, r.date_reservation, r.statut 
                                                FROM reservations r 
                                                JOIN activite a ON r.idactivite = a.id_Activite 
                                                WHERE r.idmembre = ?");
                $reservations->execute([$idmembre]);
                
                while ($row = $reservations->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <tr class='border-t'>
                        <td class='px-4 py-2'>{$row['id_reservation']}</td>
                        <td class='px-4 py-2'>{$row['nom_Activité']}</td>
                        <td class='px-4 py-2'>{$row['date_reservation']}</td>
                        <td class='px-4 py-2'>{$row['statut']}</td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<script>
    function afficherDescription() {
        const select = document.getElementById('activiteSelect');
        const descriptionDiv = document.getElementById('activity-description');
        
        const selectedOption = select.options[select.selectedIndex];
        const description = selectedOption.getAttribute('data-description');
        
        if (description) {
            descriptionDiv.innerHTML = `<p><strong>Description :</strong> ${description}</p>`;
        } else {
            descriptionDiv.innerHTML = '';
        }
    }
</script>

    </div>

    <script>
        function showConnexionForm() {
            document.getElementById('choice-section').classList.add('hidden');
            document.getElementById('connexion-form').classList.remove('hidden');
        }

        function showActivityForm() {
            document.getElementById('choice-section').classList.add('hidden');
            document.getElementById('activity-form').classList.remove('hidden');
        }
    </script>
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

