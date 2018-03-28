from django.conf.urls import url
from django.contrib import admin
from django.urls import include
from django.urls import path
from . import views

urlpatterns = [
    path('', views.home, name='home'),
    path('events/' ,views.EventListView.as_view(), name='event-list'),
    path('events/<str:pk>', views.EventDetailView.as_view(), name='event-detail'),
]
