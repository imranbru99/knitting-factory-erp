<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#115e59">
    <link rel="manifest" href="/floor.webmanifest">
    <title>Knitting floor</title>
</head>
<body>
    <h1>Roll entry</h1>
    <p>Scan or type the program, then save. If the network drops, the roll stays on this tablet until it syncs.</p>
    <form id="roll-form">
        <input id="program" placeholder="Program number" required>
        <input id="kg" type="number" step="0.01" placeholder="Net kg" required>
        <input id="gsm" type="number" step="0.1" placeholder="GSM" required>
        <button type="submit">Save roll</button>
    </form>
    <p id="queue"></p>
    <script>
        const key = 'gk-roll-queue';
        const read = () => JSON.parse(localStorage.getItem(key) || '[]');
        const write = (rows) => localStorage.setItem(key, JSON.stringify(rows));
        const paint = () => { document.getElementById('queue').textContent = read().length + ' waiting to sync'; };
        document.getElementById('roll-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const rows = read();
            rows.push({
                program: document.getElementById('program').value,
                kg: document.getElementById('kg').value,
                gsm: document.getElementById('gsm').value,
                at: new Date().toISOString()
            });
            write(rows);
            event.target.reset();
            paint();
        });
        paint();
        if ('serviceWorker' in navigator) { navigator.serviceWorker.register('/sw.js'); }
    </script>
</body>
</html>
