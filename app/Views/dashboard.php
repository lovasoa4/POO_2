<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard - CashTrack</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
body { margin:0; font-family: 'Poppins', sans-serif; background:#f5f6fa; }
.sidebar { width:220px; position:fixed; left:0; top:0; bottom:0; background:linear-gradient(180deg, #198754, #14532d); color:white; padding:20px 10px; display:flex; flex-direction:column; gap:10px; }
.sidebar h2 { text-align:center; font-size:1.2rem; }
.sidebar a { display:flex; align-items:center; gap:8px; color:white; text-decoration:none; padding:8px; border-radius:6px; transition:0.3s; font-size:0.9rem; }
.sidebar a:hover { background:rgba(255,255,255,0.2); }
.main { margin-left:240px; padding:25px; display:flex; gap:20px; }
.dashboard-left { flex:2; }
.dashboard-right { flex:1; }
h1 { text-align:center; color:#14532d; margin-bottom:30px; font-size:1.5rem; }
.cards { display:flex; gap:20px; flex-wrap:wrap; justify-content:start; }
.card { background:white; border-radius:10px; padding:15px; box-shadow:0 4px 12px rgba(0,0,0,0.08); text-align:center; width:150px; }
.value { font-size:1.1rem; font-weight:bold; }
.credit { color:#28a745; }
.debit { color:#dc3545; }
.solde { color:#0d6efd; }
#chartContainer { background:white; padding:15px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.08); height:250px; }
.filter { text-align:center; margin-bottom:10px; }
table { width:100%; border-collapse:collapse; margin-top:15px; background:white; font-size:0.85rem; }
th, td { padding:6px 8px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#198754; color:white; }
</style>
</head>
<body>

<?php 
    include ('navbar.php');
?>

<main class="main">

<div class="dashboard-left">


<div class="cards">
    <div class="card">
        <h4>Total Crédit</h4>
        <div class="value credit"><?= number_format($totalCredit ?? 0, 0, ',', ' ') ?> MGA</div>
    </div>
    <div class="card">
        <h4>Total Débit</h4>
        <div class="value debit"><?= number_format($totalDebit ?? 0, 0, ',', ' ') ?> MGA</div>
    </div>
    <div class="card">
        <h4>Solde Total</h4>
        <div class="value solde"><?= number_format($soldeTotal ?? 0, 0, ',', ' ') ?> MGA</div>
    </div>
</div>

<h2>Dernières transactions</h2>
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
<td><?= number_format($t['montant'], 0, ',', ' ') ?> MGA</td>
<td><?= htmlspecialchars($t['description']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<div class="dashboard-right">
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
<canvas id="transactionsChart" style="height:180px;"></canvas>
</div>
</div>

</main>

<script>
const dailyData = <?= json_encode($dailyTransactions ?? []) ?>;
const ctx = document.getElementById('transactionsChart').getContext('2d');
let chart;

function updateChart() {
    const labels = dailyData.map(d=>d.jour);
    const credits = dailyData.map(d=>d.total_credit);
    const debits  = dailyData.map(d=>d.total_debit);

    if(chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Crédit',
                    data: credits,
                    backgroundColor: 'rgba(245, 222, 179, 0.6)', // beige transparent
                    borderColor: 'rgba(245, 222, 179, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    hoverBackgroundColor: 'rgba(255, 193, 7, 0.8)'
                },
                {
                    label: 'Débit',
                    data: debits,
                    backgroundColor: 'rgba(255, 223, 0, 0.6)', // jaune transparent
                    borderColor: 'rgba(255, 223, 0, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    hoverBackgroundColor: 'rgba(255, 193, 7, 0.8)'
                }
            ]
        },
        options: {
            responsive:true,
            plugins: {
                legend: { position:'top' },
                tooltip: { mode:'index', intersect:false }
            },
            scales: {
                y: { beginAtZero:true },
                x: { grid:{display:false}, ticks:{font:{size:10}} }
            }
        }
    });
}

updateChart();

document.getElementById('moisFilter').addEventListener('change', e=>{
    const sel = e.target.value;
    const [mois, annee] = sel.split('-');
    // Recharge la page avec le mois sélectionné
    window.location.href = "/dashboard?mois="+mois+"&annee="+annee;
});
</script>

</body>
</html>
