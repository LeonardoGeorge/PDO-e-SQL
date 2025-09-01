<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Frutas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-remover {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-remover:hover {
            background-color: #c0392b;
        }

        .loading {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <h1>Gerenciamento de Frutas</h1>

    <div id="tabela-frutas">
        <div class="loading">Carregando frutas...</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            carregarFrutas();
        });

        function carregarFrutas() {
            fetch('api-list.php')
                .then(response => response.json())
                .then(data => {
                    exibirFrutas(data);
                })
                .catch(error => {
                    console.error('Erro ao carregar frutas:', error);
                    document.getElementById('tabela-frutas').innerHTML = '<p>Erro ao carregar frutas.</p>';
                });
        }

        function exibirFrutas(frutas) {
            if (frutas.length === 0) {
                document.getElementById('tabela-frutas').innerHTML = '<p>Nenhuma fruta cadastrada.</p>';
                return;
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço (R$)</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            frutas.forEach(fruta => {
                html += `
                    <tr id="fruta-${fruta.id}">
                        <td>${fruta.id}</td>
                        <td>${fruta.nome}</td>
                        <td>${parseFloat(fruta.preco).toFixed(2)}</td>
                        <td>${new Date(fruta.data_criacao).toLocaleString()}</td>
                        <td>
                            <button class="btn-remover" onclick="removerFruta(${fruta.id})">Remover</button>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
            `;

            document.getElementById('tabela-frutas').innerHTML = html;
        }

        function removerFruta(id) {
            if (!confirm('Tem certeza que deseja remover esta fruta?')) {
                return;
            }

            fetch('api-delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    // Remove a linha da tabela
                    document.getElementById(`fruta-${id}`).remove();

                    // Recarrega a lista para garantir que está sincronizada
                    carregarFrutas();
                })
                .catch(error => {
                    console.error('Erro ao remover fruta:', error);
                    alert('Erro ao remover fruta.');
                });
        }
    </script>
</body>

</html>