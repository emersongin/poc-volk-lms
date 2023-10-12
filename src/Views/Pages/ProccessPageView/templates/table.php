<div class="d-flex flex-column w-100">
  <table class="table table-striped table-bordered table-responsive">
    <thead>
      <tr>
        <th scope="col">Código</th>
        <th scope="col">Nome</th>
        <th scope="col">Pessoa</th>
        <th scope="col">Unidade</th>
        <th scope="col">Stado</th>
        <th scope="col">Data Criação</th>
        <th scope="col">Data Modificação</th>
        <th scope="col">Opções</th>
      </tr>
    </thead>
  </table>
  <div class="min-h-100" style="min-height: 300px; max-height: 300px; overflow-y: auto;">
    <table class="table table-striped table-bordered table-responsive">
      <tbody class="table-group-divider">
        {{rows}}
      </tbody>
    </table>
  </div>
</div>
