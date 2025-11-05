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
* { box-sizing: border-box; margin:0; padding:0; font-family:'Poppins', sans-serif; }
body { background: linear-gradient(135deg, #f6fbf7, #e9f6ee); display:flex; min-height:100vh; }

/* ===== SIDEBAR (modifié du second code) ===== */
.sidebar {
  width: 240px;
  background: #198754;
  color: #fff;
  height: 100vh;
  padding: 25px 20px;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.navbar-custom h3 {
  font-weight: 700;
  font-size: 1.3rem;
  margin-bottom: 30px;
  text-align: center;
}
.nav-links a {
  display: block;
  color: #fff;
  text-decoration: none;
  padding: 10px 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  transition: all 0.3s;
  font-size: 0.95rem;
}
.nav-links a:hover, .nav-links a.active { background: #157347; }
.user-info {
  text-align: center;
  border-top: 1px solid rgba(255,255,255,0.3);
  padding-top: 15px;
  font-size: 0.95rem;
}

/* ===== TOPBAR ===== */
.top-bar {
  position: fixed;
  top: 0;
  left: 240px;
  height: 60px;
  width: calc(100% - 240px);
  background: #47915dff;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 25px;
  z-index: 10;
}
.top-bar .user {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 500;
  color: #fff;
}
.top-bar .user i { font-size: 1.6rem; }

/* ===== MAIN CONTENT ===== */
.main-content {
  margin-left: 240px;
  margin-top: 70px;
  padding: 30px 40px;
  width: calc(100% - 240px);
}

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

<!-- SIDEBAR -->
<aside class="sidebar">
  <nav class="navbar-custom">
    <h3><i class="bi bi-wallet2"></i> CashTrack</h3>
    <div class="nav-links">
        <a href="/dashboard"class="active"><i class="bi bi-house-door"></i> Tableau de bord</a>
        <a href="/afficher" ><i class="bi bi-arrow-left-right"></i> Transactions</a>
        <a href="/transaction_Credit"><i class="bi bi-arrow-up-right-circle"></i> Crédit</a>
        <a href="/transaction_Debit"><i class="bi bi-arrow-down-right-circle"></i> Débit</a>
        <a href="/ajout"><i class="bi bi-plus-circle"></i> Ajouter transaction</a>
        <a href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>

    </div>
  </nav>
</aside>

<!-- TOPBAR -->
<div class="top-bar">
  <div class="user">
    <i class="bi bi-person-circle"></i>
    <span><?= htmlspecialchars($user_name) ?></span>
  </div>
</div>

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
