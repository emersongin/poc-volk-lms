<form class="d-flex flex-column w-100">
  <div class="row border py-1">
    <label for="inputEmail3" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Nome
    </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail3" required>
    </div>
  </div>
  <div class="row border py-1">
    <label for="inputEmail3" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Pessoas
    </label>
    <div class="col-sm-10">
      <select class="form-select" aria-label="Default select example" required>
        <option selected disabled value="">selecione uma pessoa</option>
        {{personOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="inputEmail3" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>  
      Unidades
    </label>
    <div class="col-sm-10">
      <select class="form-select" aria-label="Default select example" required>
        <option selected disabled value="">selecione uma unidade</option>
        {{unitOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="inputEmail3" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Status
    </label>
    <div class="col-sm-10">
      <select class="form-select" aria-label="Default select example" required>
        <option selected disabled value="">selecione o status</option>
        {{statusOptions}}
      </select>
    </div>
  </div>
  <div class="row border py-1">
    <label for="inputEmail3" class="col-sm-2 col-form-label">
      <span class="text-danger">*</span>
      Ações da fila
    </label>
    <div class="col-sm-10">
      <select class="form-select" aria-label="Default select example" required>
        <option selected disabled value="">selecione uma ação</option>
        {{queueActionOptions}}
      </select>
    </div>
  </div>
  <div class="d-flex gap-2 py-2 bg-body-secondary">
    <button type="submit" class="btn btn-success">Gravar</button>
    <button type="submit" class="btn btn-primary">Novo</button>
  </div>
</form>