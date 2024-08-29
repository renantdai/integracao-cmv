<x-alert />
@csrf()
<select name="tpAmb" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="1">Produção</option>
    <option value="2">Homologação</option>
</select>
<select name="verAplic" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="SVRS">SVRS</option>
</select>
<select name="tpMan" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="1">Cadastramento</option>
    <option value="2">Alteração</option>
    <option value="3">Desativação</option>
    <option value="4">Reativação</option>
</select>
<input type="text" placeholder=" AAAA-MMDDTHH:MM:SS TZD" name="dhReg" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<input type="text" placeholder="CNPJOper" name="CNPJOper" maxlength="14" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<input type="text" placeholder="Identificador do equipamento" name="cEQP" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<input type="text" placeholder="Nome amigável do equipamento" name="xEQP" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<select name="cUF" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="43">Rio Grande do Sul</option>
</select>
<select name="tpSentido" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="E">Entrada</option>
    <option value="S">Saida</option>
    <option value="I">Indeterminado</option>
</select>
<input type="text" placeholder="latitude" name="latitude" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<input type="text" placeholder="longitude" name="longitude" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
<select name="tpEQP" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
    <option value="2">OCR (Camera)</option>
    <option value="1">SLD (Antena)</option>
</select>
<input type="text" placeholder="Permite detalhar melhor a localização do
 equipamento, como ponto de referência" name="xRefCompl" value="{{ $cam->id ?? old('id') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

<button type="submit" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Enviar</button>
