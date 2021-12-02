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
    public constructor(public router: Router, private backendservice: BackendService) { 
    }

    public ngOnInit(): void {
    }

    public login(): void {
        this.backendservice.login(this.username, this.password)
        .then((result) => {
            if (result) {
                console.log("Login passt");
                this.router.navigate(['/friends']);
            }
        })
        this.router.navigate(['/friends']);
    }

    public register(): void {
        this.router.navigate(['/register']);
    }
 
}
