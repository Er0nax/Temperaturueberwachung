   M S B A M L   `   `   `  ����J  FSyntax-Sabberer, Version=1.0.0.0, Culture=neutral, PublicKeyToken=nullA%clr-namespace:Syntax_Sabberer.windowsSyntax_Sabberer.windows  5   	   ]3clr-namespace:Syntax_Sabberer.windows.DataTemplates%Syntax_Sabberer.windows.DataTemplates  5   	   )    #Syntax_Sabberer.windows.UsersWindow   5   	   R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   7local%clr-namespace:Syntax_Sabberer.windows     5   	   Hcontrols3clr-namespace:Syntax_Sabberer.windows.DataTemplates     5   	   -   5          � Title$  Users��5	   	   $	��700��5
   	   $
��1000��5   	    � 
ResizeMode$ NoResize=�5   	    � Icon$  /assets/images/favicon.ico��5   	    � WindowStartupLocation$ CenterScreen=�5   	    � WindowStyle$
 None=�5   	    � AllowsTransparency . ��5   	   Z� .��5      �� ���	#FF111111 �� CornerRadius$ 5��5      ._�5   
   � .+�5      � -   5         �Name$
 Grid��5       � RowDefinitions 5      �� 5      $��30 �6$   �� 5      $��50 �6$   �� 5      $��* �6$   �� 5      $	��100 �6$   	 � ColumnDefinitions	 5       �� 5!      $	��150 �6'   �� 5"      .+�5%      �� -   5        
 ��Name$

 drag��5%      
���   � J� Opacity$	 0.3Q�5'      $��0��5(      $��2��5)       � Cursor$
 Hand��5*      $ 5 5 0 0��5+      5,      �� 5.      -   5         ��Name$ titleBar��5.      $��0��5/      $��0��50      $��2��51      $
 Hand��52       �� Orientation$ Vertical=�53      $��Right=�54      .+�56      �� -   5         ��Name$ closeBtn��56      $��X��57      ���	#FFFF4242$��0q�59      $��30��5:      $��18(�5;      $
 Hand��5<      $��30��5=      $��Center=�5>      $��Center=�5?      $
��Bold"�5@      5A      5C      � 5E      -   5        $ topbar��5E      $��0��5F      $��1��5G      $��2��5H      .+�5J      �� $ 
Horizontal=�6!   $��Right=�5K   !   .+�5M      �� -   5        $ usernameLabel��5M       $��Eronax��5N       
�������$
 Hand��5P       $��0q�5Q       $
��Bold"�5R       $��	10 0 10 0q�5S       $��Center=�5T       $��Center=�5U       5V       A� 5X      $��30��6"   $��30��5Y   "   $��0 0 10 0q�5Z   "   
���������5]      �� 5^   "   -   5        user_avatar�� �� ImageSource$  /assets/images/default.png��5_   -   5b      5f      5h      �� 5j      -	   5        $ lastUpdatedLbl��5j      $��1��5k      $��1��5l      $��1��5m      
�������$��16(�5o      $��Center=�5p      $��Center=�5q      �� 5s      -
   5        $ 
loadingLbl��5s      $��2��5t      $��1��5u      $��Center=�5v      $��20(�5w      
�������$��Center=�5y      $��
Loading...��5z      �� 5|      -   5         ��Name$ content��5|      $��1��5}      $��2��5~      $��Hidden=�5      .��5�      �� -   5         ��Name$ 	UserCards��5�   #   ��5�   #   �� *	Sensors+��5�      �� 5�      .R�5�   "   A�  A� Rows$ 20��6.    A� Columns$ 4��5�   .   5�      ��5�      �� 5�      .R�5�   "   4   .Syntax_Sabberer.windows.DataTemplates.UserCard  5�      5�      5�      �� 5�      -   5        $

 menu��5�      ���#232323$��0��5�      $��0��5�      $ 5��5�      $��4��5�      ._�5�      � .+�5�      �� $��Syntax Sabberer��6    $
��Bold"�5�       $��16(�5�       $��Center=�5�       $��Center=�5�       $��Center=�5�       $	��Top=�5�       $��0q�5�       $��	5 15 5 15q�5�       
�������5�       �� 5�      $��0 80 0 0q�6%   .+�5�      �� -   5        $
 
sensorsBtn��5�   %   ���	#FF343434 �� Padding$ 5q�5�   %   $
��0 10q�5�   %   
�������$��0 0 0 0q�5�   %   $ 0��5�   %   $
 Hand��5�   %   ._�5�   "   �� $��Sensors��6(   $��14(�5�   (   $��Normal"�5�   (   $��Center=�5�   (   $��Center=�5�   (   
�������5�   (   5�      �� 5�      ���	#FF4D4D4D$ 5q�5�   %   $
��0 10q�5�   %   
�������$��2 0 0 0q�5�   %   $ 0��5�   %   $
 Hand��5�   %   ._�5�   "   �� $��Users��6(   $��14(�5�   (   $
��Bold"�5�   (   $��Center=�5�   (   $��Center=�5�   (   
�������5�   (   5�      �� 5�      -   5        $
 logsBtn��5�   %   ���	#FF343434$ 5q�5�   %   $
��0 10q�5�   %   
�������$��0 0 0 0q�5�   %   $ 0��5�   %   $
 Hand��5�   %   ._�5�   "   �� $
��Logs��6(   $��14(�5�   (   $��Normal"�5�   (   $��Center=�5�   (   $��Center=�5�   (   
�������5�   (   5�      �� 5�      -   5        $
 settingsBtn��5�   %   ���	#FF343434$ 5q�5�   %   $
��0 10q�5�   %   
�������$��0 0 0 0q�5�   %   $ 0��5�   %   $
 Hand��5�   %   ._�5�   "   �� $��Settings��6(   $��14(�5�   (   $��Normal"�5�   (   $��Center=�5�   (   $��Center=�5�   (   
�������5�   (   5�      5�      �� 5�      -   5        $
 	logoutBtn��5�   !   ���	#FF343434$ 5q�5�   !   $��	0 10 0 30q�5�   !   $��Bottom=�5�   !   
�������$��0 0 0 0q�5�   !   $ 0��5�   !   $
 Hand��5�   !   ._�5�      �� $��Logout��6$   $��14(�5   $   $��Normal"�5  $   $��Center=�5  $   $��Center=�5  $   
�������5  $   5     5     5     5
     5     5     5     