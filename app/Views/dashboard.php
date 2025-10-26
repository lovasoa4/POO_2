<?php
$user_name = $_SESSION["nom"] ?? "Invité";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard - CashTrack</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
/* ===== RESET ===== */
* { box-sizing: border-box; margin:0; padding:0; font-family:'Poppins', sans-serif; }
body { background: linear-gradient(135deg, #f6fbf7, #e9f6ee); display:flex; min-height:100vh; }

/* ===== TOP NAVBAR ===== */
.top-navbar {
    position: fixed; top:0; left:250px; right:0; height:60px;
    background: linear-gradient(90deg,#0f5132,#198754);
    color:white; display:flex; justify-content:space-between; align-items:center;
    padding:0 20px; z-index:100; box-shadow:0 3px 10px rgba(0,0,0,0.15);
}
.top-navbar .brand { font-weight:700; font-size:1.1rem; display:flex; align-items:center; gap:8px; }
.top-navbar .user-info { display:flex; align-items:center; gap:10px; }
.top-navbar .user-info a { color:white; text-decoration:none; border:1px solid rgba(255,255,255,0.4); padding:4px 10px; border-radius:6px; transition:0.3s; }
.top-navbar .user-info a:hover { background: rgba(255,255,255,0.15); }

/* ===== SIDEBAR ===== */
.sidebar {
    position: fixed; top:0; left:0; width:250px; height:100%;
    background: linear-gradient(180deg,#198754,#14532d);
    color:white; padding-top:80px; display:flex; flex-direction:column; gap:10px; box-shadow:4px 0 10px rgba(0,0,0,0.1);
}
.sidebar h2 { text-align:center; font-size:1.2rem; font-weight:700; margin-bottom:15px; }
.sidebar a { display:flex; align-items:center; gap:10px; color:#d1e8dc; text-decoration:none; padding:12px 16px; border-radius:8px; transition:0.3s; font-weight:500; }
.sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.15); color:#fff; padding-left:20px; }

/* ===== MAIN CONTENT ===== */
.main-content { margin-left:250px; padding-top:80px; padding:30px 40px; width:calc(100% - 250px); }

/* ===== HEADER ===== */
.page-title { font-weight:700; color:#146c43; margin-bottom:25px; font-size:1.5rem; }

/* ===== CARDS ===== */
.cards { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:30px; }
.card { background:white; border-radius:12px; padding:20px 25px; text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.08); width:180px; }
.card h4 { font-weight:600; margin-bottom:10px; }
.card .value { font-size:1.4rem; font-weight:bold; }
.card.credit { border-top:5px solid #198754; color:#198754; }
.card.debit { border-top:5px solid #dc3545; color:#dc3545; }
.card.solde { border-top:5px solid #0d6efd; color:#0d6efd; }

/* ===== TABLE ===== */
.table-container { background:white; border-radius:12px; padding:15px; box-shadow:0 3px 12px rgba(0,0,0,0.08); overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:0.85rem; }
th, td { padding:8px 10px; text-align:left; border-bottom:1px solid #ddd; }
th { background:#198754; color:white; }
tr:hover td { background:#f1fdf4; }

/* ===== CHART ===== */
#chartContainer { background:white; padding:15px; border-radius:12px; box-shadow:0 3px 12px rgba(0,0,0,0.08); margin-top:30px; }
.filter { text-align:center; margin-bottom:10px; }
.filter select { padding:5px 10px; border-radius:6px; border:1px solid #ccc; }

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .sidebar { width:200px; }
    .main-content { margin-left:200px; padding:20px; }
    .cards { justify-content:center; }
}
</style>
</head>

<body>

<!-- TOP NAVBAR -->
<header class="top-navbar">
    <div class="brand"><i class="bi bi-wallet2"></i> CashTrack</div>
    <div class="user-info">
        <i class="bi bi-person-circle"></i> <?= htmlspecialchars($user_name) ?>
        <a href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </div>
</header>

<!-- SIDEBAR -->
<aside class="sidebar">
<h2>Cash Track</h2>
<a href="#"><i class='bx bx-grid-alt'></i> Tableau de bord</a>
<a href="/afficher"><i class='bx bx-transfer'></i> Transactions</a>
<a href="/transaction_Credit"><i class='bx bx-plus-circle'></i> Crédit</a>
<a href="/transaction_Debit"><i class='bx bx-minus-circle'></i> Débit</a>
<a href="#"><i class='bx bx-log-out'></i> Déconnexion</a>
<h2>Navigation</h2>
<a href="/dashboard1" class="active"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
<a href="/afficher"><i class="bi bi-transfer"></i> Transactions</a>
<a href="transaction_Credit"><i class="bi bi-plus-circle"></i> Crédit</a>
<a href="transaction_Debit"><i class="bi bi-dash-circle"></i> Débit</a>
<a href="/ajout"><i class="bi bi-plus-square"></i> Ajouter transaction</a>
<a href="/profil"><i class="bi bi-person"></i> Profil</a>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">
<h1 class="page-title">Dashboard de <?= htmlspecialchars($nom ?? $user_name) ?></h1>

<!-- CARDS -->
<div class="cards">
    <div class="card credit">
        <h4>Total Crédit</h4>
        <div class="value"><?= number_format($totalCredit ?? 0,0,',',' ') ?> MGA</div>
    </div>
    <div class="card debit">
        <h4>Total Débit</h4>
        <div class="value"><?= number_format($totalDebit ?? 0,0,',',' ') ?> MGA</div>
    </div>
    <div class="card solde">
        <h4>Solde Total</h4>
        <div class="value"><?= number_format($soldeTotal ?? 0,0,',',' ') ?> MGA</div>
    </div>
</div>

<!-- TABLEAU DES DERNIERES TRANSACTIONS -->
<div class="table-container">
<table>
<thead>
<tr>
<th>Date</th>
<th>Type</th>
<th>Montant</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<?php foreach($lastTransactions ?? [] as $t): ?>
<tr>
<td><?= htmlspecialchars($t['date_transaction']) ?></td>
<td><?= htmlspecialchars($t['type']) ?></td>
<td><?= number_format($t['montant'],0,',',' ') ?> MGA</td>
<td><?= htmlspecialchars($t['description']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<!-- CHART -->
<div id="chartContainer">
<div class="filter">
<label for="moisFilter">Mois : </label>
<select id="moisFilter">
<?php foreach($existingMonths ?? [] as $m): ?>
<option value="<?= $m['mois'] ?>-<?= $m['annee'] ?>" <?= ($m['mois']==$selectedMonth && $m['annee']==$selectedYear)?'selected':'' ?>>
<?= $m['mois'].'/'.$m['annee'] ?>
</option>
<?php endforeach; ?>
</select>
</div>
<canvas id="transactionsChart" style="height:200px;"></canvas>
</div>
</main>

<script>
const dailyData = <?= json_encode($dailyTransactions ?? []) ?>;
const ctx = document.getElementById('transactionsChart').getContext('2d');
let chart;

function updateChart(){
    const labels = dailyData.map(d=>d.jour);
    const credits = dailyData.map(d=>d.total_credit);
    const debits = dailyData.map(d=>d.total_debit);

    if(chart) chart.destroy();

    chart = new Chart(ctx,{
        type:'bar',
        data:{
            labels:labels,
            datasets:[
                { label:'Crédit', data:credits, backgroundColor:'rgba(25,135,84,0.6)', borderColor:'rgba(25,135,84,1)', borderWidth:1, borderRadius:4, hoverBackgroundColor:'rgba(25,135,84,0.8)' },
                { label:'Débit', data:debits, backgroundColor:'rgba(220,53,69,0.6)', borderColor:'rgba(220,53,69,1)', borderWidth:1, borderRadius:4, hoverBackgroundColor:'rgba(220,53,69,0.8)' }
            ]
        },
        options:{ responsive:true, plugins:{ legend:{ position:'top' }, tooltip:{ mode:'index', intersect:false } }, scales:{ y:{ beginAtZero:true }, x:{ grid:{display:false} } } }
    });
}

updateChart();

document.getElementById('moisFilter').addEventListener('change', e=>{
    const [mois, annee] = e.target.value.split('-');
    window.location.href = "/dashboard?mois="+mois+"&annee="+annee;
});
</script>
</body>
</html>
