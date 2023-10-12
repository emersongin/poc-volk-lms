<tr>
  <th scope="row">{{id}}</th>
  <td scope="row">{{name}}</td>
  <td scope="row">{{person}}</td>
  <td scope="row">{{unit}}</td>
  <td scope="row">{{status}}</td>
  <td scope="row">{{createdAt}}</td>
  <td scope="row">{{updatedAt}}</td>
  <td scope="row" class="d-flex justify-content-center align-items-center gap-3">
    <a class="link-secondary link-opacity-75-hover fs-5" style="cursor: pointer" href="processos/cadastro?processId={{id}}">
      <i class="bi bi-search"></i>
    </a>
    <a class="link-secondary link-opacity-75-hover fs-5" style="cursor: pointer" onclick="removeProcessModal('{{id}}');">
      <i class="bi bi-x-circle"></i>
    </a>
  </td>
</tr>