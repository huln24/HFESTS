	<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    text-align: left;
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:hover {
    background-color: #f5f5f5;
}
	</style>
	</head>

	<body>
	    <h1>List of Emails Generated by a Facility</h1>
	    <h2><?= $fname ?></h2>
	    <form action="10.php" method="POST">
	        <label for="facilities">Choose a Facility:</label>
	        <select id="facilities" name="facility">
	            <?php foreach ($choices as $choice): ?>
	            <option value="<?= $choice['FID'] ?>|<?= $choice['FName'] ?>"><?= $choice['FName'] ?></option>
	            <?php endforeach; ?>
	        </select>
	        <input type="submit" name="GO" value="Go" />
	    </form>
	    <table>
	        <thead>
	            <tr>
	                <th>Date</th>
	                <th>Email Subject</th>
	                <th>Content</th>
	            </tr>
	        </thead>
	        <?php 
			$chosen = isset($records);
			if ($chosen):?>
	        <tbody>

	            <?php foreach ($records as $record): ?>

	            <tr class="table">
	                <td class="cell"><?= $record["Date"] ?></td>
	                <td class="cell"><?= $record["Subject"] ?></td>
	                <td class="cell"><?= $record["Body"] ?></td>
	            </tr>

	            <?php endforeach ?>
	        </tbody>
	        <?php endif; ?>
	    </table>