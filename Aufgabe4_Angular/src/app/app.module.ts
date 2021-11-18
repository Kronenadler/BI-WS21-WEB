import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { LogoutComponent } from './components/logout/logout.component';
import { ProfileComponent } from './components/profile/profile.component';
import { ChatComponent } from './components/chat/chat.component';
import { FriendsComponent } from './components/friends/friends.component';
import { RegisterComponent } from './components/register/register.component';
import { SettingsComponent } from './components/settings/settings.component';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ContextService } from './services/context.service';
import { IntervalService } from './services/interval.service';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    LogoutComponent,
    ProfileComponent,
    ChatComponent,
    FriendsComponent,
    RegisterComponent,
    SettingsComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [ ContextService, IntervalService ],
  bootstrap: [AppComponent]
})
export class AppModule { }
