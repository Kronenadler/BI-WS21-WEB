import { ThisReceiver } from '@angular/compiler';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';




@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})


export class LoginComponent implements OnInit {


    public username: string = '';
    public password: string = '';
    public loginSuccess: boolean = false;

    public constructor(public router: Router, private backendservice: BackendService) {
    }

    public ngOnInit(): void {

    }

    public login(): void {
        //  this.errortext.value = "none";
        /*  this.backendservice.login(this.username, this.password)
          .then((result) => {
              if (result) {
                  console.log("Login passt");
                  this.router.navigate(['/friends']);
              }*/
        //alert("anfagn");
        // this.errortext.innerText = "helo";
        this.backendservice.login(this.username, this.password)
            .then((result) => {
                if (result) {
                    this.router.navigate(['/friends']);                }
                else {


                    var errortext = document.getElementById('errortext');

                    if (errortext != null) {
                        errortext.innerText = "Authentification failed.";
                        errortext.className = "errortextShow"
                    }
                }

            })

    }

    public register(): void {
        this.router.navigate(['/register']);
    }
    //Change border to red
    /*   public setErrorFor(input: any) {
       const formControl = input.parentElement;
       //const small = formControl.querySelector('small');
       formControl.className = 'form-control active';
   }
   //Change border to green
       public setSuccessFor(input: any) {
       const formControl = input.parentElement;
       formControl.className = 'form-control hidden';
   }*/

}

