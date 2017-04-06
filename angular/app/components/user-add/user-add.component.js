class UserAddController{
    constructor(API, $state, $stateParams){
        'ngInject';
    this.$state = $state
    this.formSubmitted = false
    this.API = API
    this.alerts = []
    this.passwordError=true;
    this.name = "brian"
    this.password="Mopiou190257"
    this.email="test2@test.com"

    if ($stateParams.alerts) {
      this.alerts.push($stateParams.alerts)
    }
  }

  save (isValid) {
    this.$state.go(this.$state.current, {}, { alerts: 'test' })

    if (isValid) {
      let Users = this.API.all('users')
      let $state = this.$state

      Users.post({
        'name': this.name,
        'email': this.email,
        'password': this.password
      }).then(function () {
        let alert = { type: 'success', 'title': 'Super !', msg: 'Utilisateur ajouté.' }
      //  $state.go('app.userlist', { alerts: alert})
      }, function (response) {
        let alert = { type: 'error', 'title': 'Erreur !', msg: response.data.errors.email[0]}
        
        $state.go($state.current, { alerts: alert})
      })
    } else {
      this.formSubmitted = true
    }

  }

    $onInit(){
    }
}


export const UserAddComponent = {
    templateUrl: './views/app/components/user-add/user-add.component.html',
    controller: UserAddController,
    controllerAs: 'vm',
    bindings: {}
}
