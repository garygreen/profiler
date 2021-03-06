<table>
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
	<tr>
		<td>Laravel version</td>
		<td>{{ $app::VERSION }}</td>
	</tr>
	<tr>
		<td>Environment</td>
		<td>{{ App::environment() }}</td>
	</tr>
	<tr>
		<td>PHP</td>
		<td>{{ phpversion() }}</td>
	</tr>
	<tr>
		<td>Loaded modules</td>
		<td>{{ implode(", ", get_loaded_extensions()) }}</td>
	</tr>
	<tr>
		<td>Timezone</td>
		<td>{{ Config::get('app.timezone') }}</td>
	</tr>
	<tr>
		<td>Locale</td>
		<td>{{ Config::get('app.locale') }}</td>
	</tr>
</table>

