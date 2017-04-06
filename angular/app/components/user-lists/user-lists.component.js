class UserListsController {
  constructor ($scope, $state, $compile, DTOptionsBuilder, DTColumnBuilder, API,AclService) {
    'ngInject'
    this.API = API
    this.$state = $state
    this.can = AclService.can
    let Users = this.API.service('users')

    Users.getList()
      .then((response) => {
        let dataSet = response.plain()

        this.dtOptions = DTOptionsBuilder.newOptions()
          .withOption('data', dataSet)
          .withOption('createdRow', createdRow)
          .withOption('responsive', true)
          .withLanguage({
            "sEmptyTable":     "Aucun utilisateur enregistré",
            "sInfo":           "Page _START_ sur _END_ avec _TOTAL_ utilisateurs",
            "sInfoEmpty":      "Rien à afficher",
            "sInfoFiltered":   "(filtered from _MAX_ total entries)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Voir _MENU_ résultats",
            "sLoadingRecords": "Chargement...",
            "sProcessing":     "Processing...",
            "sSearch":         "Recherche:",
            "sZeroRecords":    "Aucun résultat ne correpond à votre recherche",
            "oPaginate": {
                "sFirst":    "Premier",
                "sLast":     "Dernier",
                "sNext":     "Suivant",
                "sPrevious": "Precedent"
            },
            "oAria": {
                "sSortAscending":  ": activate to sort column ascending",
                "sSortDescending": ": activate to sort column descending"
            }
          })

          .withBootstrap()
        if(this.can('manage.users')){
          this.dtColumns = [
            DTColumnBuilder.newColumn('id').withTitle('ID'),
            DTColumnBuilder.newColumn('name').withTitle('Nom'),
            DTColumnBuilder.newColumn('email').withTitle('Email'),
            DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
              .renderWith(actionsHtml)
          ]
        }else{
          this.dtColumns = [
            DTColumnBuilder.newColumn('id').withTitle('ID'),
            DTColumnBuilder.newColumn('name').withTitle('Nom'),
            DTColumnBuilder.newColumn('email').withTitle('Email')
          ]
        }




        this.displayTable = true
      })

    let createdRow = (row) => {
      $compile(angular.element(row).contents())($scope)
    }

       let actionsHtml = (data) => {
           return `
                     <a class="btn btn-xs btn-warning" ng-show="vm.can('manage.users')"  ui-sref="app.useredit({userId: ${data.id}})">
                         <i class="fa fa-edit"></i>
                     </a>
                     &nbsp
                     <button class="btn btn-xs btn-danger" ng-show="vm.can('delete.user')" ng-click="vm.delete(${data.id})">
                         <i class="fa fa-trash-o"></i>
                     </button>`

      }

    }


  delete (userId) {
    let API = this.API
    let $state = this.$state



    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this data!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: true,
      showLoaderOnConfirm: true,
      html: false
    }, function () {
      API.one('users', userId).remove()
        .then(() => {
          /*
          swal({
            title: 'Deleted!',
            text: 'User Permission has been deleted.',
            type: 'success',
            confirmButtonText: 'OK',
            closeOnConfirm: true
          }, function () {
            $state.reload()
          })
          */
          $state.reload()


        })
    })
  }

  $onInit () {

  //  console.log(JSON.stringify(this.$state.params));
  }
}

export const UserListsComponent = {
  templateUrl: './views/app/components/user-lists/user-lists.component.html',
  controller: UserListsController,
  controllerAs: 'vm',
  bindings: {}
}
