import { Component, OnInit } from '@angular/core';
import { SelectMultipleControlValueAccessor } from '@angular/forms';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';
import { ContextService } from 'src/app/services/context.service';

@Component({
    selector: 'app-register',
    templateUrl: './register.component.html',
    styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
    public passwordOk: boolean = false;
    public usernameOk: boolean = false;
    public username: string = '';
    public password1: string = '';
    public password2: string = '';
    public password1Ok: boolean = false;

    public constructor(private router: Router, private contextService: ContextService, private backendService: BackendService) {
        this.backendService.register("sepp", "12345678");
        console.log("sepp created");
    }

    public ngOnInit(): void {

    }

    public createAccount(): void {
        console.log(this.usernameOk + " " + this.passwordOk);
        this.backendService.register(this.username, this.password1).then(() => { this.router.navigate(['/login']) });
    }

    public checkUsername(): void {
        console.log("checked");
        if (this.username != null && this.username.length > 2) {
            this.backendService.userExists(this.username)       //Then -> User existiert; Catch -> User noch nicht da
                .then((result) => {
                    if (result) {
                        this.usernameOk = false;
                        console.log("User exisitiert");
                    }
                    else {
                        this.usernameOk = true;
                        console.log("User exisitiert nicht");
                    }
                })}
        else {
                this.usernameOk = false;
            }
            console.log(this.usernameOk);

        }
    public checkPassword1(): void {
        if (this.password1.length > 7) {
            if (this.password1 != null || this.password1 != '') {
                this.password1Ok = true;
                console.log("password1Ok: " + this.password1Ok)
            }
        }
        else {
            this.password1Ok = false;
        }

    }
    public checkPassword2(): void {

        if (this.password1 == this.password2 && this.password1Ok) {
            this.passwordOk = true;
        }
        else {
            this.passwordOk = false;
        }
        console.log("after pw2: " + this.passwordOk);
    }
}

