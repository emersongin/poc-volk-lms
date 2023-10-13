<form method="POST" class="d-flex flex-column w-100">
  <div class="row border py-1">
    <label for="nameLabel" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Nome
    </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nameLabel" name="name" value="{{name}}" {{disabled}} required>
    </div>
  </div>
  <div class="row border py-1">
    <label for="personLabel" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Pessoas
    </label>
    <div class="col-sm-10">
      <select id="personLabel" class="form-select"  name="personId" {{disabled}} required>
        <option selected disabled value="">selecione uma pessoa</option>
        {{personOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="unitLabel" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>  
      Unidades
    </label>
    <div class="col-sm-10">
      <select id="unitLabel" class="form-select" name="unitId" {{disabled}} required>
        <option selected disabled value="">selecione uma unidade</option>
        {{unitOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="statusLabel" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Status
    </label>
    <div class="col-sm-10">
      <select id="statusLabel" class="form-select" name="statusId" required>
        <option selected disabled value="">selecione o status</option>
        {{statusOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="queueActionLabel" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Ações da fila
    </label>
    <div class="col-sm-10">
      <select id="queueActionLabel" class="form-select" name="queueActionId" {{disabled}} required>
        <option selected disabled value="">selecione uma ação</option>
        {{queueActionOptions}}
      </select>
    </div>
  </div>
  <input type="hidden" name="processId" value="{{processId}}">
  <div class="d-flex gap-2 p-2 bg-body-secondary">
    <button type="submit" class="btn btn-success">Gravar</button>
    <a href="/processos/cadastro">
      <button type="submit" class="btn btn-primary" disabled>Novo</button>
    </a>
  </div>
</form>