import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    public constructor(public router: Router) { 
    }

    public ngOnInit(): void {
    }

    public login(): void {
        this.router.navigate(['/friends']);
    }

    public register(): void {
        this.router.navigate(['/register']);
    }

}
