<tr>
  <th>{{id}}</th>
  <td>{{name}}</td>
  <td>{{person}}</td>
  <td>{{unit}}</td>
  <td>{{status}}</td>
  <td>{{createdAt}}</td>
  <td>{{updatedAt}}</td>
  <td class="d-flex justify-content-center align-items-center gap-3">
    <a class="link-secondary link-opacity-75-hover fs-5" style="cursor: pointer" href="processos/cadastro?processId={{id}}">
      <i class="bi bi-search"></i>
    </a>
    <a class="link-secondary link-opacity-75-hover fs-5" style="cursor: pointer" onclick="removeProcessModal('{{id}}');">
      <i class="bi bi-x-circle"></i>
    </a>
  </td>
</tr>